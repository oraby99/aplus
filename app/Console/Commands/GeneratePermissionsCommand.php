<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GeneratePermissionsCommand extends Command
{
    protected $signature = 'shield:generate';
    protected $description = 'Generate Spatie permissions and policies for all Filament resources (Alternative to Filament Shield)';

    public function handle()
    {
        $this->info('Scanning Filament Resources...');

        $resourcesPath = app_path('Filament/Resources');
        $files = File::allFiles($resourcesPath);

        $models = [];

        foreach ($files as $file) {
            if (Str::endsWith($file->getFilename(), 'Resource.php')) {
                $content = File::get($file->getPathname());
                // Extract the model class name
                if (preg_match('/protected static \?string \$model = ([a-zA-Z0-9_]+)::class;/', $content, $matches)) {
                    $models[] = $matches[1];
                }
            }
        }

        $models = array_unique($models);
        $permissionsCount = 0;

        // Also add general permissions
        $models[] = 'Role';
        $models[] = 'Permission';

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        foreach ($models as $model) {
            $name = Str::snake($model);
            
            $actions = ['view_any', 'view', 'create', 'update', 'delete'];
            
            foreach ($actions as $action) {
                $permissionName = "{$action}_{$name}";
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $superAdminRole->givePermissionTo($permission);
                $permissionsCount++;
            }

            // Generate Policy
            $this->generatePolicy($model, $name);
        }

        $this->info("Successfully generated {$permissionsCount} permissions for " . count($models) . " models!");
        $this->info("Super Admin role has been updated with all permissions.");
        
        // Give the first user the super_admin role
        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            $firstUser->assignRole($superAdminRole);
            $this->info("Assigned 'super_admin' role to User: {$firstUser->name}");
        }

        $this->info("Policies have been created in app/Policies.");
    }

    protected function generatePolicy($modelName, $snakeName)
    {
        $policyPath = app_path("Policies/{$modelName}Policy.php");
        
        if (!File::exists(app_path('Policies'))) {
            File::makeDirectory(app_path('Policies'));
        }

        $content = <<<EOT
<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class {$modelName}Policy
{
    use HandlesAuthorization;

    public function viewAny(User \$user): bool
    {
        return \$user->hasPermissionTo('view_any_{$snakeName}') || \$user->hasRole('super_admin');
    }

    public function view(User \$user, \$model = null): bool
    {
        return \$user->hasPermissionTo('view_{$snakeName}') || \$user->hasRole('super_admin');
    }

    public function create(User \$user): bool
    {
        return \$user->hasPermissionTo('create_{$snakeName}') || \$user->hasRole('super_admin');
    }

    public function update(User \$user, \$model = null): bool
    {
        return \$user->hasPermissionTo('update_{$snakeName}') || \$user->hasRole('super_admin');
    }

    public function delete(User \$user, \$model = null): bool
    {
        return \$user->hasPermissionTo('delete_{$snakeName}') || \$user->hasRole('super_admin');
    }
}
EOT;

        File::put($policyPath, $content);
    }
}

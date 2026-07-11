<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Level;
use App\Models\Group;
use App\Models\ClassSession;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Installment;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate/delete existing demo data to allow safe re-runs
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Certificate::truncate();
        \App\Models\Evaluation::truncate();
        \App\Models\Project::truncate();
        \App\Models\Attendance::truncate();
        \App\Models\ClassSession::truncate();
        \App\Models\Enrollment::truncate();
        \App\Models\Installment::truncate();
        \App\Models\Payment::truncate();
        \App\Models\Group::truncate();
        \App\Models\Level::truncate();
        \App\Models\Course::truncate();
        \App\Models\Competition::truncate();
        \App\Models\Testimonial::truncate();
        \App\Models\TrialSession::truncate();
        User::whereIn('type', ['teacher', 'student'])->delete();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $parentRole = Role::firstOrCreate(['name' => 'parent']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'أحمد محمود',
            'email' => 'ahmed.teacher@academy.com',
            'password' => bcrypt('password'),
            'type' => 'teacher',
            'phone' => '01012345678',
            'is_active' => true,
        ]);
        $teacher1->assignRole($teacherRole);

        $teacher2 = User::create([
            'name' => 'سارة كمال',
            'email' => 'sara.teacher@academy.com',
            'password' => bcrypt('password'),
            'type' => 'teacher',
            'phone' => '01087654321',
            'is_active' => true,
        ]);
        $teacher2->assignRole($teacherRole);

        // Create Students
        $students = [];
        $studentNames = ['زين أحمد', 'عبدالرحمن أيمن', 'تيم محمد', 'روان محمود', 'سيف علي', 'فاطمة سامي'];
        $schools = ['مدرسة عمر بن الخطاب', 'مدرسة النيل الدولية', 'المنارة الحديثة', 'رواد الغد الخاصة', 'الإبداع الدولية', 'مدرسة القاهرة التجريبية'];
        
        foreach ($studentNames as $i => $name) {
            $student = User::create([
                'name' => $name,
                'email' => 'student'.$i.'@academy.com',
                'password' => bcrypt('password'),
                'type' => 'student',
                'phone' => '012' . rand(10000000, 99999999),
                'age' => rand(7, 14),
                'parent_name' => 'ولي أمر ' . $name,
                'parent_phone' => '010' . rand(10000000, 99999999),
                'birth_date' => Carbon::now()->subYears(rand(7, 14))->subDays(rand(1, 365)),
                'school' => $schools[$i],
                'is_active' => true,
            ]);
            $student->assignRole($studentRole);
            $students[] = $student;
        }

        // Create Courses
        $course1 = Course::create([
            'title' => 'برمجة سكراتش للأطفال',
            'description' => 'كورس تعليم أساسيات البرمجة للأطفال باستخدام سكراتش بطرق تفاعلية وممتعة.',
            'price' => 1500,
            'is_active' => true,
        ]);

        $course2 = Course::create([
            'title' => 'بايثون للمبتدئين',
            'description' => 'تعلم لغة بايثون بطريقة ممتعة ومبسطة للأطفال واليافعين.',
            'price' => 2500,
            'is_active' => true,
        ]);

        // Create Levels
        $level1 = Level::create(['course_id' => $course1->id, 'name' => 'المستوى الأول: أساسيات سكراتش', 'order' => 1]);
        $level2 = Level::create(['course_id' => $course1->id, 'name' => 'المستوى الثاني: الألعاب المتقدمة', 'order' => 2]);
        $level3 = Level::create(['course_id' => $course2->id, 'name' => 'المستوى الأول: مبادئ بايثون', 'order' => 1]);

        // Create Groups
        $group1 = Group::create([
            'level_id' => $level1->id,
            'teacher_id' => $teacher1->id,
            'name' => 'مجموعة سكراتش A1',
            'max_students' => 10,
            'schedule' => 'السبت والأربعاء 5 مساءً',
        ]);

        $group2 = Group::create([
            'level_id' => $level3->id,
            'teacher_id' => $teacher2->id,
            'name' => 'مجموعة بايثون P1',
            'max_students' => 12,
            'schedule' => 'الأحد والخميس 6 مساءً',
        ]);

        // Enroll Students & Create Payments
        foreach ($students as $index => $student) {
            $group = ($index < 3) ? $group1 : $group2;
            $course = $group->level->course;

            Enrollment::create([
                'student_id' => $student->id,
                'group_id' => $group->id,
                'start_date' => Carbon::now()->subDays(rand(1, 30)),
                'status' => 'active',
            ]);

            // Payments
            $payment = Payment::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'total_amount' => $course->price,
                'paid_amount' => $course->price / 2, // Paid half
                'discount' => 100,
                'payment_plan' => 'installments',
                'status' => 'partial',
            ]);

            // Installments
            Installment::create([
                'payment_id' => $payment->id,
                'amount' => ($course->price / 2) - 100,
                'due_date' => Carbon::now()->subDays(10),
                'paid_date' => Carbon::now()->subDays(10),
                'status' => 'paid',
            ]);

            Installment::create([
                'payment_id' => $payment->id,
                'amount' => $course->price / 2,
                'due_date' => Carbon::now()->addDays(20),
                'paid_date' => null,
                'status' => 'pending',
            ]);
        }

        // Create Class Sessions & Attendance
        for ($i = 1; $i <= 5; $i++) {
            $session = ClassSession::create([
                'group_id' => $group1->id,
                'session_date' => Carbon::now()->subDays(30 - ($i * 5)),
                'topic' => 'أساسيات البرمجة والحركة - الدرس رقم ' . $i,
            ]);

            foreach (array_slice($students, 0, 3) as $student) {
                Attendance::create([
                    'class_session_id' => $session->id,
                    'student_id' => $student->id,
                    'status' => rand(1, 10) > 2 ? 'present' : 'absent',
                    'notes' => 'حضور تفاعلي متميز',
                ]);
            }
        }

        // 1. Seed Competitions (ongoing and upcoming for homepage)
        \App\Models\Competition::create([
            'title' => 'هاكاثون البرمجة الصيفي للأطفال 🚀',
            'description' => 'تحدي برمجي لبناء أفضل لعبة إبداعية باستخدام سكراتش وجوائز قيمة للفائزين المراكز الأولى.',
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'status' => 'ongoing',
        ]);

        \App\Models\Competition::create([
            'title' => 'مسابقة الذكاء الاصطناعي الكبرى 🤖',
            'description' => 'صمم نموذج ذكاء اصطناعي تفاعلي بسيط لحل مشكلة بيئية. مفتوحة لكافة الأعمار.',
            'start_date' => Carbon::now()->addDays(15),
            'end_date' => Carbon::now()->addDays(25),
            'status' => 'upcoming',
        ]);

        // 2. Seed Trial Sessions
        \App\Models\TrialSession::create([
            'student_name' => 'علي عمر البطل',
            'age' => 9,
            'parent_phone' => '01031224400',
            'session_date' => Carbon::now()->addDays(3),
            'status' => 'pending',
            'notes' => 'يفضل برمجة الألعاب ويحب روبوتيكس',
        ]);

        \App\Models\TrialSession::create([
            'student_name' => 'مريم يوسف',
            'age' => 11,
            'parent_phone' => '01091474341',
            'session_date' => Carbon::now()->subDays(1),
            'status' => 'attended',
            'notes' => 'حضرت وتفاعلت جداً في الحصة التجريبية',
        ]);

        // 3. Seed Projects
        $projectImages = [
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ];
        
        \App\Models\Project::create([
            'student_id' => $students[0]->id,
            'course_id' => $course1->id,
            'title' => 'لعبة صائد الكائنات الفضائية 🛸',
            'description' => 'لعبة شيقة يقوم فيها اللاعب بصيد الكائنات باستخدام الفأرة لتسجيل النقاط.',
            'project_url' => 'https://scratch.mit.edu',
            'image_path' => $projectImages[0],
        ]);

        \App\Models\Project::create([
            'student_id' => $students[1]->id,
            'course_id' => $course1->id,
            'title' => 'متاهة الغابة السحرية 🌳',
            'description' => 'لعبة ذكاء يحتاج فيها اللاعب لتوجيه البطل للخروج من المتاهة وتجنب الحواجز.',
            'project_url' => 'https://scratch.mit.edu',
            'image_path' => $projectImages[1],
        ]);

        \App\Models\Project::create([
            'student_id' => $students[2]->id,
            'course_id' => $course2->id,
            'title' => 'مشروع حساب كتلة الجسم بالبايثون 🐍',
            'description' => 'برنامج تفاعلي يطلب من المستخدم بياناته ويحسب له حالته الصحية والنصائح الغذائية.',
            'project_url' => 'https://github.com',
            'image_path' => $projectImages[2],
        ]);

        // 4. Seed Evaluations
        \App\Models\Evaluation::create([
            'student_id' => $students[0]->id,
            'teacher_id' => $teacher1->id,
            'course_id' => $course1->id,
            'score' => 95,
            'feedback' => 'أداء متميز وتفاعل استثنائي، قام بإنهاء المشروع بنجاح كبير.',
            'evaluation_date' => Carbon::now()->subDays(5),
        ]);

        \App\Models\Evaluation::create([
            'student_id' => $students[1]->id,
            'teacher_id' => $teacher1->id,
            'course_id' => $course1->id,
            'score' => 88,
            'feedback' => 'ممتاز في التفكير المنطقي، يحتاج فقط لمزيد من التدريب على المفاهيم المتقدمة.',
            'evaluation_date' => Carbon::now()->subDays(5),
        ]);

        // 5. Seed Certificates
        \App\Models\Certificate::create([
            'student_id' => $students[0]->id,
            'course_id' => $course1->id,
            'issue_date' => Carbon::now()->subDays(2),
            'serial_number' => 'A-PLUS-' . rand(100000, 999999),
        ]);

        \App\Models\Certificate::create([
            'student_id' => $students[1]->id,
            'course_id' => $course1->id,
            'issue_date' => Carbon::now()->subDays(2),
            'serial_number' => 'A-PLUS-' . rand(100000, 999999),
        ]);

        // 6. Seed Testimonials
        \App\Models\Testimonial::create([
            'name' => 'أميرة يوسف (والدة زين)',
            'course_name' => 'سكراتش المستوى الأول',
            'score' => 5,
            'feedback' => 'ابني زين أصبح شغوفاً بالكمبيوتر ويحب بناء الألعاب بنفسه بدلاً من تضييع الوقت في اللعب فقط! تجربة ممتازة مع المدربين.',
            'is_approved' => true,
        ]);

        \App\Models\Testimonial::create([
            'name' => 'محمد أحمد (والد عبدالرحمن)',
            'course_name' => 'بايثون للمبتدئين',
            'score' => 5,
            'feedback' => 'أكاديمية رائعة والتعامل راقٍ جداً، خطة واضحة ومستويات متدرجة تلائم عقلية الطفل وتجعله يفكر بمنطق وحكمة.',
            'is_approved' => true,
        ]);
    }
}

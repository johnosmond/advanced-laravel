<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ClassType;
use App\Models\ScheduledClass;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InstructorTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_is_redirected_to_instructor_dashboard()
    {
        // arrange
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        // act
        $response = $this->actingAs($user)->get('/dashboard');

        // assert
        $response->assertRedirectToRoute('instructor.dashboard');

        $this->followRedirects($response)->assertSeeText("Hey Instructor");
    }

    public function test_instructor_can_schedule_a_class()
    {
        // arrange
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);

        // act
        $response = $this->actingAs($user)
            ->post('instructor/schedule', [
                'class_type_id' => ClassType::first()->id,
                'date' => '2023-08-08',
                'time' => '09:00:00'
            ]);

        // assert
        $this->assertDatabaseHas('scheduled_classes', [
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-08-08 09:00:00',
        ]);

        $response->assertRedirectToRoute('schedule.index');
    }

    public function test_instructor_can_delete_a_class()
    {
        // arrange
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);

        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-08-08 09:00:00'
        ]);

        // act
        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/' . $scheduledClass->id);

        // assert
        $this->assertDatabaseMissing('scheduled_classes', [
            'id' => $scheduledClass->id
        ]);
    }

    public function test_instructor_cannot_cancel_class_less_than_two_hours_before_class_start()
    {
        // arrange
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);

        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => now()->addHour()->minutes(0)->seconds(0)
        ]);

        // act I
        $response = $this->actingAs($user)->get('instructor/schedule');

        // assert I
        $response->assertDontSee('Cancel');

        // act II
        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/' . $scheduledClass->id);

        // assert II
        $this->assertDatabaseHas('scheduled_classes', [
            'id' => $scheduledClass->id
        ]);

    }
}

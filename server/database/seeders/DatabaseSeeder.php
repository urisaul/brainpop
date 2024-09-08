<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '1234',
        ]);

        $quiz = \App\Models\Quiz::factory()->create([
            'name' => 'First Grade Science Quiz',
        ]);

        // Create related questions
        $questions = [
            [
                'question_text' => 'What do plants need to grow?',
                'answers' => [
                    ['id' => 'A', 'text' => 'Candy'],
                    ['id' => 'B', 'text' => 'Sunlight'],
                    ['id' => 'C', 'text' => 'Sand'],
                    ['id' => 'D', 'text' => 'Juice']
                ],
                'correct_answer' => 'B'
            ],
            [
                'question_text' => 'Which one of these animals can fly?',
                'answers' => [
                    ['id' => 'A', 'text' => 'Elephant'],
                    ['id' => 'B', 'text' => 'Dog'],
                    ['id' => 'C', 'text' => 'Bird'],
                    ['id' => 'D', 'text' => 'Fish']
                ],
                'correct_answer' => 'C'
            ],
            [
                'question_text' => 'What color is the sky on a clear day?',
                'answers' => [
                    ['id' => 'A', 'text' => 'Green'],
                    ['id' => 'B', 'text' => 'Blue'],
                    ['id' => 'C', 'text' => 'Red'],
                    ['id' => 'D', 'text' => 'Yellow']
                ],
                'correct_answer' => 'B'
            ],
            [
                'question_text' => 'What do we use to see?',
                'answers' => [
                    ['id' => 'A', 'text' => 'Nose'],
                    ['id' => 'B', 'text' => 'Hands'],
                    ['id' => 'C', 'text' => 'Eyes'],
                    ['id' => 'D', 'text' => 'Ears']
                ],
                'correct_answer' => 'C'
            ],
            [
                'question_text' => 'Which of these is a fruit?',
                'answers' => [
                    ['id' => 'A', 'text' => 'Carrot'],
                    ['id' => 'B', 'text' => 'Apple'],
                    ['id' => 'C', 'text' => 'Bread'],
                    ['id' => 'D', 'text' => 'Cheese']
                ],
                'correct_answer' => 'B'
            ],
        ];

        // Attach questions to the quiz
        foreach ($questions as $question) {
            $quiz->questions()->create($question);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamAttempt;

class AutoSubmitActiveAttempts
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            $currentRoute = $request->route() ? $request->route()->getName() : null;
            
            // Allow only the taking page, answer storage page, and manual submit page
            $allowedRoutes = [
                'student.exams.attempt.take',
                'student.exams.attempt.answers.store',
                'student.exams.attempt.submit',
            ];

            if (!in_array($currentRoute, $allowedRoutes)) {
                $activeAttempts = ExamAttempt::where('student_id', Auth::id())
                    ->where('status', 'in_progress')
                    ->get();

                foreach ($activeAttempts as $attempt) {
                    $attempt->submit();
                }
            }
        }

        return $next($request);
    }
}

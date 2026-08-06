<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\Hrd\PerubahanStatusController;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PkwtVerificationTest extends TestCase
{
    /**
     * Test that verifyPkwt method gracefully handles database query exceptions
     * by logging the error with detailed context and returning a 404 exception.
     */
    public function testVerificationGracefullyHandlesExceptionAndLogsError()
    {
        $logPath = storage_path('logs/laravel.log');
        
        // Truncate the log file
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        $controller = new PerubahanStatusController();

        $exceptionThrown = false;
        try {
            $controller->verifyPkwt(999999);
        } catch (NotFoundHttpException $e) {
            $exceptionThrown = true;
            $this->assertEquals(404, $e->getStatusCode());
            $this->assertEquals('PKWT document not found', $e->getMessage());
        }

        $this->assertTrue($exceptionThrown, "NotFoundHttpException was expected but not thrown.");

        // Read log contents
        $logContent = File::exists($logPath) ? File::get($logPath) : '';
        
        // Assert that the log contains our custom error message indicating query failure
        $this->assertStringContainsString('PKWT Verification Error', $logContent);
        $this->assertTrue(
            strpos($logContent, 'no such table: hrd_perubahan_status') !== false || 
            strpos($logContent, 'could not find driver') !== false,
            "Log should contain 'no such table: hrd_perubahan_status' or 'could not find driver'."
        );
        $this->assertStringContainsString('"id":999999', $logContent);
        $this->assertStringContainsString('ip_address', $logContent);
    }
}

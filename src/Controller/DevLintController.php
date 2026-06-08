<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Simple dev-only controller to run project linters via the web PHP process.
 * Only enabled when the kernel environment is "dev".
 */
class DevLintController extends AbstractController
{
    #[Route('/_dev/lint', name: 'dev_lint', methods: ['GET'])]
    public function lint(KernelInterface $kernel): Response
    {
        if ($kernel->getEnvironment() !== 'dev') {
            return new Response('Not allowed in non-dev environment.', 403);
        }

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $commands = [
            ['cmd' => 'lint:twig', 'args' => ['paths' => ['templates/']]],
            ['cmd' => 'lint:yaml', 'args' => ['paths' => ['config/']]],
            ['cmd' => 'doctrine:schema:validate', 'args' => []],
        ];

        $report = [];

        foreach ($commands as $c) {
            $inputArgs = array_merge(['command' => $c['cmd']], $c['args']);
            $input = new ArrayInput($inputArgs);
            $output = new BufferedOutput();
            try {
                $exitCode = $application->run($input, $output);
                $report[] = [
                    'command' => $c['cmd'],
                    'exit' => $exitCode,
                    'output' => $output->fetch(),
                ];
            } catch (\Throwable $e) {
                $report[] = [
                    'command' => $c['cmd'],
                    'exception' => $e->getMessage(),
                ];
            }
        }

        $body = "<html><body><h1>Dev lint report</h1>";
        foreach ($report as $r) {
            $body .= '<h2>' . htmlspecialchars($r['command']) . '</h2>';
            if (isset($r['exception'])) {
                $body .= '<pre style="color:red">' . htmlspecialchars($r['exception']) . '</pre>';
            } else {
                $body .= '<pre>' . htmlspecialchars($r['output']) . '</pre>';
                $body .= '<p>Exit code: ' . intval($r['exit']) . '</p>';
            }
        }
        $body .= '</body></html>';

        return new Response($body);
    }
}

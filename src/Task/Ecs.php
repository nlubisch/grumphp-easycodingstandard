<?php

declare(strict_types=1);

namespace NLubisch\GrumPHP\Task;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Ecs extends AbstractExternalTask
{
    public function getName(): string
    {
        return 'ecs';
    }

    public function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'whitelist_patterns' => [],
            'fix' => false,
        ]);

        $resolver->addAllowedTypes('whitelist_patterns', ['array']);
        $resolver->addAllowedTypes('fix', ['bool']);

        return $resolver;
    }

    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    public function run(ContextInterface $context)
    {
        $config = $this->getConfiguration();
        $whitelistPatterns = $config['whitelist_patterns'];
        $fix = $config['fix'];

        $arguments = $this->processBuilder->createArgumentsForCommand('ecs');
        $arguments->add('check');

        foreach ($whitelistPatterns as $whitelistPattern) {
            $arguments->add($whitelistPattern);
        }

        if ($fix) {
            $arguments->add('--fix');
        }

        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $this->formatter->format($process));
        }

        return TaskResult::createPassed($this, $context);
    }
}

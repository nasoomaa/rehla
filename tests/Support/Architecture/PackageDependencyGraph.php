<?php

namespace Tests\Support\Architecture;

final class PackageDependencyGraph
{
    public function violations(string $packagesRoot, array $expected): array
    {
        $packages = [];

        foreach ($this->manifests($packagesRoot) as $manifest) {
            $name = $manifest['name'];
            $packages[$name] = $this->firstPartyDependencies($manifest);
        }

        $violations = [];

        foreach (array_diff_key($expected, $packages) as $name => $_) {
            $violations[] = "missing package: {$name}";
        }

        foreach (array_diff_key($packages, $expected) as $name => $_) {
            $violations[] = "unexpected package: {$name}";
        }

        foreach (array_intersect_key($packages, $expected) as $name => $dependencies) {
            $actualDependencies = $dependencies;
            $expectedDependencies = $expected[$name];
            sort($actualDependencies);
            sort($expectedDependencies);

            if ($actualDependencies !== $expectedDependencies) {
                $violations[] = sprintf(
                    'direct dependencies for %s: expected [%s], actual [%s]',
                    $name,
                    implode(', ', $expectedDependencies),
                    implode(', ', $actualDependencies),
                );
            }
        }

        $violations = [...$violations, ...$this->cycles($packages)];
        $violations = array_values(array_unique($violations));
        sort($violations);

        return $violations;
    }

    private function manifests(string $packagesRoot): array
    {
        $manifests = [];
        $paths = glob($packagesRoot.'/*/composer.json') ?: [];
        sort($paths);

        foreach ($paths as $path) {
            $manifests[] = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);
        }

        return $manifests;
    }

    private function firstPartyDependencies(array $manifest): array
    {
        return array_values(array_filter(
            array_keys($manifest['require'] ?? []),
            static fn (string $dependency): bool => str_starts_with($dependency, 'rehla/'),
        ));
    }

    private function cycles(array $packages): array
    {
        $visiting = [];
        $visited = [];
        $stack = [];
        $cycles = [];
        $names = array_keys($packages);
        sort($names);

        $visit = function (string $name) use (&$visit, &$visiting, &$visited, &$stack, &$cycles, $packages): void {
            $visiting[$name] = true;
            $stack[] = $name;

            $dependencies = $packages[$name];
            sort($dependencies);

            foreach ($dependencies as $dependency) {
                if (! array_key_exists($dependency, $packages)) {
                    continue;
                }

                if (isset($visiting[$dependency])) {
                    $cycle = array_slice($stack, array_search($dependency, $stack, true));
                    $cycle[] = $dependency;
                    $cycles[] = 'circular dependency: '.implode(' -> ', $cycle);

                    continue;
                }

                if (! isset($visited[$dependency])) {
                    $visit($dependency);
                }
            }

            array_pop($stack);
            unset($visiting[$name]);
            $visited[$name] = true;
        };

        foreach ($names as $name) {
            if (! isset($visited[$name])) {
                $visit($name);
            }
        }

        return $cycles;
    }
}

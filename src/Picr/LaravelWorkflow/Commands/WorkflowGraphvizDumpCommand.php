<?php
namespace Picr\LaravelWorkflow\Commands;

use Illuminate\Console\Command;
use Config;
use Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use ReflectionProperty;
use Workflow;

class WorkflowGraphvizDumpCommand extends Command {
    protected $signature = 'workflow:graphviz-dump
        {workflow : name of workflow from configuration}
        {--format= : graphics format output}';
    protected $description = 'GraphvizDumper dumps a workflow as a graphviz file.
        You can convert the generated dot file with the dot utility (http://www.graphviz.org/):';

    public function handle() {
        $workflowName = $this->argument('workflow');
        $config = Config::get('workflow');

        if ( !isset($config[$workflowName]) ) throw new Exception("There is not a workflow called $workflowName configured.");

        $className = $config[$workflowName]['supports'][0];

        $workflow = Workflow::get(new $className, $workflowName);

        $property = new ReflectionProperty($workflow, 'definition');
        $property->setAccessible(true);
        $definition = $property->getValue($workflow);

        $dumper = new GraphvizDumper();

        if ( ! $outputType = $this->option('format') ) {
            $this->output->writeln($dumper->dump($definition));

            return;
        }

        $process = new Process('dot -T' . $outputType);
        $process->setInput($dumper->dump($definition));
        $process->mustRun();
        $output = $process->getOutput();
        file_put_contents($workflowName . '.' . $outputType, $output);
    }
}
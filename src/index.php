<?php

//var_dump($argv);
require_once __DIR__ . '/vendor/autoload.php';

use Repository\GitRepository;

$console = new Console($argv);
$console->verify_services()->prepare_args();
$output = $console->makeRequest();

if ($console->is_sha1($output)) {
    echo $output;
    echo " \r\n";
} else {
    $message = json_decode($output);
    echo 'ups something goes wrong.';
    echo " \r\n";
    echo $message->message;
    echo " \r\n";
}


class Console
{

    public $args;
    public $withService = false;
    private $repository;
    private $branch;
    private $service = 'git';

    public function __construct($argv)
    {
        $this->args = $argv;
    }

    public function verify_services()
    {
        $opts = array(
            "service::",    // Optional value
        );
        $options = getopt('', $opts);
        $services = ['github', 'git'];
        if (!empty($options) && !in_array($options['service'], $services)) {
            echo 'Unknown or not implemented yet service :' . $options['service'];
            echo " \r\n";
            exit();
        } elseif (in_array($options['service'], $services)) {
            $this->setService($options['service']);
        }

        if (!empty($options['service'])) {
            $this->withService = true;
        }
        return $this;
    }

    public function is_sha1($str)
    {
        return (bool)preg_match('/^[0-9a-f]{40}$/i', $str);
    }

    public function prepare_args()
    {

        if ($this->withService) {
            $this->repository = $this->args[2];
            $this->branch = $this->args[3];
        } else {
            $this->repository = $this->args[1];
            $this->branch = $this->args[2];
        }
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return mixed
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    public function makeRequest()
    {

        switch ($this->getService()) {
            case 'git':
            case 'github':
                $service = new GitRepository();

                break;
        }

        return $service->makeRequest($this->getRepository(), $this->getBranch());

    }

}

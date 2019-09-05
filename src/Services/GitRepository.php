<?php
declare(strict_types=1);

namespace Repository;

class GitRepository implements Repository
{
    /**
     * @var string
     */
    private $repositoryAddress;
    /**
     * @var string
     */
    private $repositoryProvider;
    private $output;

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }


    private function setRepositoryAddress(string $repositoryAddress)
    {
        $this->repositoryAddress = $repositoryAddress;
    }

    private function setRepositoryProvider(string $repositoryProvider)
    {
        $this->repositoryProvider = $repositoryProvider;
    }

    private function getRepositoryAddress()
    {
        return $this->repositoryAddress;
    }

    private function getRepositoryProvider()
    {
        return $this->repositoryProvider;
    }

    public function makeRequest($repositoryName, $branch)
    {
        $this->setRepositoryProvider('https://api.github.com/');


        $handle = curl_init();
        $url = $this->getRepositoryProvider() . 'repos/' . $repositoryName . '/commits/' . $branch;
// Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
// Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.github.VERSION.sha',
        ));
        $this->output = curl_exec($handle);

        curl_close($handle);

        return $this->getOutput();
    }
}

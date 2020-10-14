<?php

/**
 * Test of sql-splitter command line tool.
 *
 * @copyright Copyright (C) David Palmero.
 * @license __LICENSE__
 */

namespace Palmiot\SqlSplitter\Test;

use Palmiot\SqlSplitter\SqlSplitterCli;
use PHPUnit\Framework\TestCase;

/**
 * Class type
 *
 * Have some tests for the class SQLSplitterCli.
 *
 */
class SqlSplitterCliTest extends TestCase
{

    /**
	 * This method check if SQlSplitterCli can be return the help info.
     * @return void
	 */
    public function testGetHelpInfo()
    {
        $this->assertStringContainsString('** SQL Splitter **', $this->getInstanceOutput());
    }

    /**
	 * This method check if SQlSplitterCli allow the short argument version.
     * @return void
	 */
    public function testAcceptShortArguments()
    {
        $argv = [
            'i' => $this->getPathOfDatabases(),
            'o' => $this->getPathOfOutputDatabases(),
            'p' => 'test',
            's' => true,
            'j' => true,
            'l' => true
        ];
        $this->getInstanceOutput($argv);
        $databases = ['university', 'student', 'exam'];
        foreach($databases as $database){
            $file = $this->getPathOfOutputDatabases().'test_'.$database.'.sql';
            $this->assertFileExists($file);
            @unlink($file);
        }
        @unlink($this->getPathOfOutputDatabases().'dump.sql');
    }

    /**
	 * This method check if SQlSplitterCli allow the large argument version.
     * @return void
	 */
    public function testAcceptLargeArguments()
    {
        $argv = [
            'input' => $this->getPathOfDatabase(),
            'output' => $this->getPathOfOutputDatabases(),
            'prefix' => 'test',
            'stream' => true,
            'join' => true,
            'logs' => true
        ];
        $this->getInstanceOutput($argv);
        $file = $this->getPathOfOutputDatabases().'test_dbalone.sql';
        $this->assertFileExists($file);
        @unlink($file);
        @unlink($this->getPathOfOutputDatabases().'test_dump.sql');
    }

    /**
	 * This method check if SQlSplitterCli can generate a dump file.
     * @return void
	 */
    public function testGenerateDumpFile()
    {
        $argv = [
            'input' => $this->getPathOfDatabase(),
            'output' => $this->getPathOfOutputDatabases(),
            'prefix' => 'test',
            'join' => true,
            'logs' => true
        ];
        $this->getInstanceOutput($argv);
        $file = $this->getPathOfOutputDatabases().'test_dbalone.sql';
        $this->assertFileExists($file);
        @unlink($file);
        @unlink($this->getPathOfOutputDatabases().'test_dump.sql');
    }

    /**
	 * This method check if SQlSplitterCli can overwrite a exist file.
     * @return void
	 */
    public function testDoNotOverwrite()
    {
        $argv = [
            'input' => $this->getPathOfDatabase(),
            'output' => $this->getPathOfOutputDatabases(),
            'prefix' => 'test',
            'logs' => true
        ];
        $this->getInstanceOutput($argv);
        $this->assertStringContainsString('Remove file and try again', $this->getInstanceOutput($argv));
        @unlink($this->getPathOfOutputDatabases().'test_dbalone.sql');
    }

    /**
	 * This method check if SQlSplitterCli can return a logs.
     * @return void
	 */
    public function testGetLogs()
    {
        $argv = [
            'input' => $this->getPathOfDatabase(),
            'output' => $this->getPathOfOutputDatabases(),
            'logs' => true
        ];
        $this->getInstanceOutput($argv);
        $this->assertStringContainsString('does not been', $this->getInstanceOutput($argv));
        @unlink($this->getPathOfOutputDatabases().'dbalone.sql');
    }

    /**
	 * This method pass arguments to new instance of SqlSplitterCli and return the output.
	 * @method string getInstanceOutput()
     * @return string STDOUT
	 */
    public function getInstanceOutput($argv = []){
        return (new SqlSplitterCli($argv))->run();
    }

    /**
	 * This method return a path of a file with single database inside.
	 * @method string getPathOfDatabase()
     * @return string Path of file.
	 */
    public static function getPathOfDatabase(): string
    {
        return __DIR__ . '/fixtures/database.sql';
    }

    /**
	 * This method return a path of a file with multiple databases inside.
	 * @method string getPathOfDatabases()
     * @return string Path of file.
	 */
    public static function getPathOfDatabases(): string
    {
        return __DIR__ . '/fixtures/alldatabases.sql';
    }

    /**
	 * This method return a path where can be save the splitted databases.
	 * @method string getPathOfOutputDatabases()
     * @return string Path or folder.
	 */
    public static function getPathOfOutputDatabases(): string
    {
        return __DIR__ . '/../databases/';
    }
}

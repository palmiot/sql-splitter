<?php

/**
 * Test of sql-splitter tool.
 *
 * @copyright Copyright (C) David Palmero.
 * @license __LICENSE__
 */

namespace Palmiot\SqlSplitter\Test;

use Palmiot\SqlSplitter\SqlSplitter;
use PHPUnit\Framework\TestCase;

/**
 * Class type
 *
 * Have some tests for the class SQLSplitter.
 *
 */
class SqlSplitterTest extends TestCase
{
    /**
     * Property instance.
     * @var SqlSplitter
     */
    protected $instance;

    /**
	 * This method set instance once time.
     * @return void
	 */
    public function setUp(): void
    {
        $this->instance = new SqlSplitter();
    }

    /**
	 * This method check if SQlSplitter can be generate the splitted databases from a file with all them.
     * @return void
	 */
    public function testSplitMultipleDatabasesFromAFile()
    {
        $this->instance->setFrom($this->getPathOfDatabases());
		$this->instance->split();
        $databases = array_keys($this->instance->getDatabases());
        $this->assertEquals('university', $databases[0]);
        $this->assertEquals('student', $databases[1]);
        $this->assertEquals('exam', $databases[2]);
    }

    /**
	 * This method check if SQlSplitter can be generate the splitted databases from a string with all them.
     * @return void
	 */
    public function testSplitMultipleDatabasesFromAStringData(){
        $this->instance->setData(file_get_contents($this->getPathOfDatabases()));
		$this->instance->split();
        $databases = array_keys($this->instance->getDatabases());
        $this->assertEquals('university', $databases[0]);
        $this->assertEquals('student', $databases[1]);
        $this->assertEquals('exam', $databases[2]);
    }

    /**
	 * This method check if SQlSplitter can be generate single databases from a file.
     * @return void
	 */
    public function testSplitSingleDatabaseFromAFile()
    {
        $this->instance->setFrom($this->getPathOfDatabase());
		$this->instance->split();
        $databases = array_keys($this->instance->getDatabases());
        $this->assertEquals('dbalone', $databases[0]);
    }

    /**
	 * This method check if SQlSplitter can be save the splitted databases into the output folder.
     * @return void
	 */
    public function testSaveSplittedDatabases(){
        $this->instance->setFrom($this->getPathOfDatabases());
		$this->instance->split();
        $this->instance->save();
        $databases = array_keys($this->instance->getDatabases());
        foreach($databases as $database){
            $file = ''.$this->instance->getTo().$database.'.sql';
            $this->assertFileExists($file);
            @unlink($file);
        }
    }

    /**
	 * This method check if SQlSplitter can be save a dump file with all splitted databases.
     * @return void
	 */
    public function testSaveDumpOfSplittedDatabases(){
        $this->instance->setFrom($this->getPathOfDatabases());
		$this->instance->split();
        $this->instance->saveJoin();
        $databases = array_keys($this->instance->getDatabases());
        $file = ''.$this->instance->getTo().'dump.sql';
        $this->assertFileExists($file);
        @unlink($file);
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


}

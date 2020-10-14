<?php

/**
 * SQL Splitter Tool.
 *
 * @copyright Copyright (C) David Palmero.
 * @license MIT
 */

namespace Palmiot\SqlSplitter;

/**
 * Class type
 *
 * Is a tool for split SQL databases from a file or string.
 *
 */
class SqlSplitter
{
    /**
     * This variable contains the path or directory of .sql file to split.
     * @var string
     */
	private $from;

    /**
     * This variable contains the path or directory where save the splitted databases.
     * @var string
     */
	private $to = __DIR__ . '/../databases/';

	/**
     * This variable is the prefix of all output splitted databases.
     * @var string
     */
	private $prefix = '';

    /**
     * This variable contains the information dummped on this instace and that will be split.
     * @var string
     */
	private $data;

    /**
     * This variable contains all splitted databases found, indexed by name.
     * @var array
     */
	private $databases = [];

    /**
     * This variable contains the exceptions occurred, each element are a real element of class "Exception".
     * @var array
     */
	private $log = [];


	// Getters

	/**
     * Getter for obtain the name of file .sql if defined.
     * @return string Path or name of .sql file.
     */
	public function getFrom()
	{
		return $this->from;
	}

	/**
     * Getter for obtain the name of folder where save the splitted .sql files.
     * @return string Path to directory where save splitted databases.
     */
	public function getTo()
	{
		return $this->to;
	}

	/**
     * Getter for obtain the actual prefix of future splitted database.
     * @return string The prefix.
     */
	public function getPrefix()
	{
		return (!empty($this->prefix)) ? $this->prefix.'_' : '';
	}

	/**
     * Getter for obtain data dumpped into the instance.
     * @return string Dump as string format.
     */
	public function getData()
	{
		return $this->data;
	}

	/**
     * Getter for obtain the databases found into $data.
     * @return array Array of databases splitted, indexed by name.
     */
	public function getDatabases()
	{
		return $this->databases;
	}

	/**
     * Getter for obtain the list of log messages.
     * @return array Each message are a element of real PHP Exception Class.
     */
	public function getLog()
	{
		return $this->log;
	}



	// Setters

	/**
	 * Setter of file .sql that contains all databases before split.
	 * @param string $from Folder and name of .sql file.
     * @return void
	 */
	public function setFrom(string $from)
	{
		$this->from = $from;
		if(!empty($this->from))
		{
			$this->setData(file_get_contents($this->from));
		}
	}

	/**
	 * Setter of folder where save the splitted .sql files after.
	 * @param string $to Path to folder.
     * @return void
	 */
	public function setTo(string $to)
	{
		$this->to = (substr("testers", -1) == '/') ? $to : $to.DIRECTORY_SEPARATOR;
	}

	/**
	 * Setter of folder where save the splitted .sql files after.
	 * @param string $to Path to folder.
     * @return void
	 */
	public function setPrefix(string $prefix)
	{
		$this->prefix = $prefix;
	}

	/**
	 * Setter of data dump into the instance
	 * @param string $data The output of dump as string format.
     * @return void
	 */
	public function setData(string $data)
	{
		$this->data = $data;
	}

	/**
	 * Setter of a database into the instance before save.
	 * @param string $name Name of database.
	 * @param string $content Content of database.
     * @return void
	 */
	public function setDatabase(string $name, string $content)
	{
		$this->databases[$name] = $content;
	}

	/**
	 * Setter for register a new log message.
	 * @param string $message new message.
     * @return void
	 */
	private function setLog(string $message)
	{
		array_push($this->log, new \Exception(''.date("Y-m-d H:i:s").' => '.$message."\n"));
	}



	// Functions

	/**
	 * This method split the databases and add each into the instance.
	 * @method void split()
     * @return void
	 */
	public function split()
	{
		$parts = preg_split('\'CREATE DATABASE\'', $this->getData(), -1, PREG_SPLIT_NO_EMPTY);
		for ($i = 1; $i <= count($parts) - 1; $i++)
		{
			$dbname = preg_split("/\`(.*?)\`/", $parts[$i], -1, PREG_SPLIT_DELIM_CAPTURE)[1];
			$this->setDatabase((!empty($dbname)) ? $dbname : 'noname_'.$i, 'CREATE DATABASE IF NOT EXISTS' . $parts[$i] . 'USE ' . $dbname);
		}
	}

	/**
	 * This method save each database of the instance into "$to" directory.
	 * @method void save()
     * @return void
	 */
	public function save(){
		foreach($this->getDatabases() as $database => $content)
		{
			$file = $this->getTo().$this->getPrefix().$database.'.sql';
			if (!file_exists($file))
			{
				if (!file_put_contents($file, $content))
				{
					$this->setLog('Error saving "'.$database.'", check permissions of folder '.$this->getTo().'');
				}
			}
			else
			{
				$this->setLog('The file "'.$this->getPrefix().$database.'.sql" does not been replace into the folder "'.$this->getTo().'" for security reasons. Remove file and try again.');
			}
		}
	}

	/**
	 * This method save all splitted databases of the instance into "$to" folder as one file or similar to original source.
	 * @method void saveJoin()
     * @return void
	 */
	public function saveJoin(){
		$data = '';
		foreach($this->getDatabases() as $database => $content)
		{
			$data .= $content;
		}
		$file = $this->getTo().$this->getPrefix().'dump.sql';
		if (!file_exists($file))
		{
			if (!file_put_contents($file, $data))
			{
				$this->setLog('Error saving "'.$this->getPrefix().'dump.sql", check permissions of folder '.$this->getTo().'');
			}
		}
		else
		{
			$this->setLog('The file "'.$this->getPrefix().'dump.sql" does not been replace into the folder "'.$this->getTo().'" for security reasons. Remove file and try again.');
		}
	}


}

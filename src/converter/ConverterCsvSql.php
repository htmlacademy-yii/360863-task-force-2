<?php

namespace TaskForce\Converter;

use TaskForce\Exception\SourceFileException;

class ConverterCsvSql
{
    const DATABASE_NAME = 'task_force';
    private string $fileSource = 'src/data/';
    private string $csvFilename;
    private object $csvFileObject;

    public function __construct(string $filename)
    {
        $this->csvFilename = $filename;
    }

    public function import():void
    {
        if (!file_exists($this->csvFilename)) {
            throw new SourceFileException;
        }

        $this->csvFileObject = new \SplFileObject($this->csvFilename);
        $this->csvFileObject->rewind();
        $columns = $this->csvFileObject->current();
        $columns = explode(',' , $columns);
        foreach ($columns as $key => $column){
            $columns[$key ] = preg_replace( '/[^[:print:]]/', '',$column);
        }
        $columns = implode(',' , $columns);

        $tableName = basename($this->csvFilename, '.csv');
        $sqlFilename = $this->fileSource . $tableName . '.sql';
        $sqlFileObject = new \SplFileObject($sqlFilename, 'w');
        $sqlFileObject->fwrite( "use " . self::DATABASE_NAME . ";\n");
        $sqlFileObject->fwrite("INSERT INTO $tableName ($columns) VALUES \n");

        $array = [];
        foreach ($this->getNextLine() as $value) {
            $array[] = "($value)";
        }
        $array = implode(", \n" , $array);
        $sqlFileObject->next();
        $sqlFileObject->fwrite($array);

    }

    private function getNextLine():?iterable {

        while (!$this->csvFileObject->eof()) {
            $array =[];
            $result = $this->csvFileObject->fgetcsv();

            foreach($result as $value) {
                if(!is_numeric($value)) {
                    $array[] = "'$value'";
                } else {
                    $array[] = "$value";
                }
            }
            yield implode(',', $array);
        }
    }
}

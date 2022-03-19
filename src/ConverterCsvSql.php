<?php

namespace TaskForce;

class ConverterCsvSql
{
    private string $csvFilename;
    const DATABASE_NAME = 'task_force';
    private string $tableName;
    private object $csvFileObject;
    private object $sqlFileObject;
    private string $columns;

    public function __construct(string $filename)
    {
        $this->csvFilename = $filename;
    }

    public function import():void
    {
        $name = explode('.', $this->csvFilename);
        $filename = explode('/', $name[0]);

        $this->sqlFilename = $name[0] . '.sql';
        $this->tableName = array_pop($filename);

        $this->csvFileObject = new \SplFileObject($this->csvFilename);
        $this->csvFileObject->rewind();
        $this->columns = $this->csvFileObject->current();
        $columns = explode(',' , $this->columns);
        foreach ($columns as $key => $column){
            $columns[$key ] = preg_replace( '/[^[:print:]]/', '',$column);
        }
        $this->columns = implode(',' , $columns);

        $this->sqlFileObject = new \SplFileObject($this->sqlFilename, 'w');
        $this->sqlFileObject->fwrite( "use " . self::DATABASE_NAME . ";\n");
        $this->sqlFileObject->fwrite("INSERT INTO $this->tableName ($this->columns) VALUES \n");

        $array = [];
        foreach ($this->getNextLine() as $value) {
            $array[] = "($value)";
        }
        $array = implode(", \n" , $array);
        $this->sqlFileObject->next();
        $this->sqlFileObject->fwrite($array);

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

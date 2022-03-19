<?php

namespace TaskForce;

class ConverterCsvSql
{
    public  string $csvFilename;
    const DATABASE_NAME = 'task_force';
    public  string $tableName;
    public  object $csvFileObject;
    public  object $sqlFileObject;
    public string $columns;

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
        $this->csvFileObject->next();

        $this->sqlFileObject = new \SplFileObject($this->sqlFilename, 'w');
        $this->sqlFileObject->rewind();
        $this->sqlFileObject->fwrite( "use " . self::DATABASE_NAME . "; \n " );
        $this->sqlFileObject->next();
        $this->sqlFileObject->fwrite("insert into $this->tableName ($this->columns) values \n");

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

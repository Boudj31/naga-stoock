<?php
 
 namespace App\Factory;
 
 use App\Entity\Computer;
 
 class ComputerFactory
 {
     /**
      * @param string[] $serials
      *
      * @return Computer[]
      */
     public function bulkCreate(array $serials, Computer $pattern): array
     {
         $computers = [];
         foreach ($serials as $serial) {
             $newComputer = clone $pattern;
             $newComputer->setSerial($serial);
             $computers[] = $newComputer;
         }
 
         return $computers;
     }
 }
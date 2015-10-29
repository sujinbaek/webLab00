<html>
   <head>
      <title>Result page</title>
   </head>
   
   <body>

   <h1>Results</h1>
   <?php
      try{
         $whichDB = $_POST["dbname"];
         $db = new PDO("mysql:dbname=$whichDB", "root", "root");
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
         $inputQuery = $_POST["query"];
         $inputQuery = stripcslashes($inputQuery); 
         
         $rows = $db->query($inputQuery);
         

         foreach ($rows as $row) { ?>
            <ul>
              <?php
                foreach ($row as $key => $val) {
                  if(!is_numeric($key)){ ?>
                      <li><?= $key ?> : <?= $val ?></li>
                    <?php } 
                } ?>
            </ul>
         <?php }
      } catch (PDOException $e){
         ?>
            <p>(Error details: <?= $e->getMessage() ?>)</p>
         <?php 
      } ?>
   </body>
</html>
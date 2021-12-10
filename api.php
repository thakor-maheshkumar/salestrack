<?php

$servername = "localhost";
$username = "root";
$password = "root@123456";
$dbname = "sodwebsi_vennel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//$uploadDir = "https://sodwebsites.co.uk/vennel/";
$uploadDir = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$uploadDir=str_replace('api.php','',$uploadDir);


/*$sql = "SELECT * FROM wp_posts";*/
/*$sql="SELECT p.post_title as name,p.post_date as datea,p.guid as book_url,p.post_content as description
FROM wp_posts p INNER JOIN
     wp_postmeta pms 
     ON pms.post_id = p.id AND pms.meta_key = '_cmb_title_2' INNER JOIN   
     wp_postmeta pmp     
     ON pmp.post_id = p.id AND pmp.meta_key = '_cmb_title_2' INNER JOIN
     wp_postmeta pmc
     ON pmc.meta_value = p.id AND p.post_type = 'attachment'
     WHERE p.post_type='event'
     AND p.post_type='publish'";*/
     
     $date=date('Y-m-d');
    $sql="SELECT 
                 p.post_title AS name,
                 p.post_name as slug,
                 p.id as event_id,
                 concat('$uploadDir','eventcalendar/',p.post_name) AS bookurl,
                 DATE_FORMAT(pm4.meta_value, '%d %M %Y') as eventdate,
                 p.post_content as description, 
                 concat('$uploadDir','wp-content/uploads/',pm2.meta_value) AS image
                 
          FROM `wp_posts` AS p

          LEFT JOIN `wp_postmeta` AS pm1 ON pm1.post_id = p.id  AND pm1.meta_key = '_thumbnail_id'
   
          LEFT JOIN `wp_postmeta` AS pm2 ON pm2.post_id = pm1.meta_value AND pm2.meta_key = '_wp_attached_file'

          INNER JOIN `wp_postmeta` AS pm3 ON pm3.post_id = p.id  AND pm3.meta_key = '_EventURL'

          INNER JOIN `wp_postmeta` AS pm4 ON pm4.post_id = p.id  AND pm4.meta_key = '_EventStartDate'  
          
          WHERE p.post_type='tribe_events'
         
          AND p.post_status='publish'

          AND DATE_FORMAT(pm4.meta_value, '%Y-%m-%d') >='$date'

          ORDER BY pm4.meta_value ASC";

    $result = $conn->query($sql);

    
    
   $myArray=array();
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $myArray[] = $row;
    }
    
  
  if(!empty($myArray))
  {
    $final=array();
    foreach($myArray as $m)
    {
      $data['name']= trim($m['name']);
      $data['slug']= trim($m['slug']);
      $data['event_id']= trim($m['event_id']);
      $data['bookurl']= trim($m['bookurl']);
      $data['eventdate']= trim($m['eventdate']);

      
      $data['description']= htmlentities(strip_tags($m['description'],ENT_QUOTES));
      
      $data['image']= trim($m['image']);
      $final[] = $data;
    }
  }
  //echo '<pre>';print_r($final);exit;
  header('Content-Type: application/json');
  
  $param = array(
          "isError"=>!empty($myArray) ? false : true,
          "message"=>!empty($myArray) ? "Event data found successfully" : "Event data not found",
          "data"=>[
            "event_list"=> $final
          ]
    );
   echo json_encode($param,JSON_PRETTY_PRINT);
}

$conn->close();
?> 

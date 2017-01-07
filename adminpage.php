<?php
include("navbar.php");
global $conn;

include("connection.php");


?>

<!DOCTYPE html>
<html>
    <head><link href="site2.css" rel="stylesheet"></head>
<body>
    
    <div class="container">
        <ul class="tab">
      <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Users')">Users</a></li>
      <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Questions')" id="defaultOpen">Questions</a></li>
        </ul>

        <div id="Users" class="tabcontent">

          <?php
            $query = "select * from asker";
            
            if($result = mysqli_query($conn, $query)) 
            {
            while($row = mysqli_fetch_array($result))
            {
                $u_ask=$row["uid"];
             $score=("SELECT CASE WHEN score IS NULL THEN 0 ELSE score END user_score, asker.uid from asker left outer join (SELECT sum(votes) as score,uid from question left outer join vote on qid=quesid where vtype ='q' GROUP by uid) scr on asker.uid=scr.uid WHERE asker.uid='$u_ask'");
$sc=mysqli_query($conn,$score);
$re=mysqli_fetch_array($sc);
                
                $ques_count=("select asker.uid, CASE WHEN Q_CNT IS NULL THEN 0 ELSE Q_CNT END AS Ques_Count FROM asker left outer join 
(SELECT uid,count(*) as Q_CNT FROM question group by uid) q_count 
on asker.uid = q_count.uid where asker.uid='$u_ask'");
$c=mysqli_query($conn,$ques_count);
$r=mysqli_fetch_array($c);
         ?>
            
            <p> </p> 
            <a href="profile.php?id= <?php echo $row['uid'] ?>">
             <h4>   <img width='35' height='40' src='./profile_pictures/<?php echo $row['username']; ?>' onerror='this.src=`./profile_pictures/defaultpic.png`'> <?php echo $row['username']; ?> </h4>
            </a> 
            <?php echo" <p> Score:".$re['user_score'];?>
            <?php echo" <p> Number of Questions Asked:".$r['Ques_Count'];?>
         <?php
                
            }
            }
         ?>
            
        </div>

        <div id="Questions" class="tabcontent">
            
           <?php include("adminpage_questionstab.php"); ?>
            
        </div>

       
    </div>
</body>
    <script>document.getElementById("defaultOpen").click();</script>
</html>
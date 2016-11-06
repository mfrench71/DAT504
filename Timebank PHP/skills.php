<?php require_once 'header.php';

$skills = queryMysql("SELECT * FROM skills");

?>

<h3>Step 2: Please tell us what skills you can offer and/or what skills you require:</h3>

<form method='post' action='skills.php'>    
    <table style="border: 1px solid silver;">
    <tr>
        <th>Skill Name</th>
        <th>I can OFFER this skill</th>
        <th>I NEED this skill</th>
    </tr>
        
    <?php while ($row = $skills->fetch_assoc()) { ?>    
    <tr>
        <td><?=$row["skillname"];?></td>
        <td><input type="radio" name = "skill-<?=$row['id'];?>"
                   <?php if (isset($_POST['skill-'.$row['id']]) && $_POST['skill-'.$row['id']] == "skillOffered") echo "checked"; ?>
                   value = "skillOffered"></td>
        <td><input type="radio" name = "skill-<?=$row['id'];?>"
                  <?php if (isset($_POST['skill-'.$row['id']]) && $_POST['skill-'.$row['id']] == "skillRequested") echo "checked"; ?>
                   value = "skillRequested"></td>
    </tr>
        
    <?php } ?>
    
    </table>
        <span class='fieldname'>&nbsp;</span>
        <input type='submit' value='Submit'>
</form>

<?php require_once 'footer.php'; ?>
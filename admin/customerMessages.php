<?php
include "inc/header.php";
?>

<?php
    if (isset($_GET['dl'])) {
       $contact->deleteMessage($_GET['dl']);
    }
?>
<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<h1>Message from customers <a href="customerMessages.php" class="btn btn-outline-secondary float-right">Refresh</a></h1>
<div class="card-body">
    <table class="table text-center table-bordered">
<?php
    $msgs = $contact->getMessages();
    $rows = $msgs->num_rows;
     if ($rows > 0) { ?>
        <tr>
            <th>Seri</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Subject</th>
            <th>tanggal</th>
            <th>Action</th>
        </tr>
<?php
        $i = 0;
        while ($msg = $msgs->fetch_assoc()) {
            $i++;
?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $msg['name']; ?></td>
            <td><?php echo $msg['email']; ?></td>
            <td><?php echo $msg['subject']; ?></td>
            <td class="text-center">
                <?php 
                echo $fm->relative_Time($msg['date_time'])."<br>";
                echo date("D-d-m-Y h:i:s a", $msg['date_time']); 
                ?>
            </td>
            <td>
                <a href="viewMessage.php?msg_id=<?php echo $msg['id']; ?>">View</a>
                <?php if ($msg['status']=='seen') { ?>
                    <a href="?dl=<?php echo $msg['id']; ?>" onClick="return confirm('Are you sure?')" class="text-danger">| Remove</a>    
                <?php } ?>
            </td>
        </tr>
<?php } }else{ ?>
    <h4 class="text-danger text-center font-italic">Message not available !</h4>
<?php } ?>
    </table>
</div>
</main>

<?php include "inc/footer.php"; ?>
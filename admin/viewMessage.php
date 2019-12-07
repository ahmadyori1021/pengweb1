<?php
include "inc/header.php";
?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
    <h1>Message and Reply <a href="customerMessages.php" class="btn btn-outline-secondary float-right">Go Back</a></h1>
<div class="card-body">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php
                if (isset($_GET['msg_id'])) {
                    $val = $contact->getSingleMessage($_GET['msg_id']);
            ?>
                <table class="table font-italic">
                    <tr>
                        <td class="font-weight-bold">Subject</td>
                        <td>:</td>
                        <td><?php echo $val['subject']; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Message</td>
                        <td>:</td>
                        <td><?php echo $val['message']; ?></td>
                    </tr>
                </table>
            <hr><br>
            <h4 class="text-center">Message Reply</h4>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['send'])) {
        $reply = $contact->messageReply($_POST);
        echo $reply;
    }
?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="to">To</label>
                    <input type="email" name="to" id="to" value="<?php echo $val['email']; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="to">From</label>
                    <input type="email" name="from" id="to" placeholder="Enter email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="from">Subject</label>
                    <input type="text" name="subject" id="from" placeholder="Enter subject" class="form-control">
                </div>
                <div class="form-group">
                    <label for="reply">Reply</label>
                    <textarea name="reply" id="reply" class="form-control">Hello, <?php echo $val['name']."."; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="send" class="btn btn-primary btn-block" value="Send">
                </div>
            </form>
            <?php } ?>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</main>

<?php include "inc/footer.php"; ?>
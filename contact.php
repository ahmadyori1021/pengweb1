<?php
include 'inc/header.php';
?>

<div class="container">
<div class="card">
    <h1 class="text-secondary text-center card-header">Contact</h1>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php
                    if (isset($_POST['submit'])) {
                        $msgSending = $contact->userMessageSend($_POST);
                        echo $msgSending;
                    }
                ?>
                <form action="" method="post">
                <?php if (session::get('cust_login') == false) { ?>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control"
                               placeholder="Your name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control"
                               placeholder="Email address">
                    </div>
                <?php }else{ ?>
                        <input type="hidden" name="name" value="<?php echo session::get('cust_name'); ?>">
                        <input type="hidden" name="email" value="<?php echo session::get('cust_email'); ?>">
                <?php } ?>
                    <div class="form-group">
                        <input type="text" name="subject" class="form-control"
                               placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" placeholder="Write your message..."></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Send"
                               class="btn btn-outline-success btn-block">
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
</div>

<?php include 'inc/footer.php'; ?>
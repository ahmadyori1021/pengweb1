<?php

class contact
{
	public function userMessageSend($value)
	{
		$name = mysqli_real_escape_string(db::conn(), $value['name']);
        $email = mysqli_real_escape_string(db::conn(), $value['email']);
        $subject = mysqli_real_escape_string(db::conn(), $value['subject']);
        $message = mysqli_real_escape_string(db::conn(), $value['message']);

        if ($name == "" || $email == "" || $subject == "" || $message == ""){
        	return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }else{
        	$time = time();
        	$query = "INSERT INTO contact(name, email, subject, message, status, date_time) 
                          VALUES
                          ('$name', '$email', '$subject', '$message', 'pending', '$time')";
            $result = db::insert($query);
            if ($result) {
                return "<div class='alert alert-success'>Message sent successfully.</div>";
            } else {
                return "<div class='alert alert-danger'>Message send failed ! Try again.</div>";
            }
        }
	}

	public function pendingMessage()
	{
		$query = "SELECT * FROM contact WHERE status = 'pending'";
		$result = db::select($query);
		$rows = $result->num_rows;
		return $rows;
	}

	public function getMessages()
	{
		$query = "SELECT * FROM contact ORDER BY id DESC";
		$result = db::select($query);
		return $result;
	}

	public function getSingleMessage($id)
	{
		$id = mysqli_real_escape_string(db::conn(), $id);
		$msgSeenQuery = "UPDATE contact SET status = 'seen' WHERE id = '$id'";
		db::update($msgSeenQuery);
		$query = "SELECT * FROM contact WHERE id = '$id'";
		$result = db::select($query)->fetch_assoc();
		return $result;
	}

	public function messageReply($val)
	{
		$to = mysqli_real_escape_string(db::conn(), $val['to']);
		$from = mysqli_real_escape_string(db::conn(), $val['from']);
		$subject = mysqli_real_escape_string(db::conn(), $val['subject']);
		$reply = mysqli_real_escape_string(db::conn(), $val['reply']);

		if ($from == "" || $subject == ""){
        	return "<div class='alert alert-danger'>Please fill out this field !</div>";
        }else{
        	$result = mail($to, $subject, $reply, $from);
        	if (!$result) {
        		return "<div class='alert alert-danger'>Your mail was not sent !</div>";
        	}
        }
	}

	public function deleteMessage($id)
	{
		$id = mysqli_real_escape_string(db::conn(), $id);
		$q = "DELETE FROM contact WHERE id = '$id'";
		db::delete($q);
	}


}
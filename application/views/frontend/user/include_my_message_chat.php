<?php
foreach ($la_chat as $chat) {
    ?>
    <div class="clearfix"></div>
    <?php
//    echo "<pre>";
//    print_r($chat);
    $toolTrip = $chat->from_username . "&#013;" . date("D d M, Y H:i:s", strtotime($chat->created_on));
    $subject = ($chat->subject != 'chat') ? "<i>$chat->subject</i><br>" : "";
    if ($user['id'] == $chat->send_from) {
        if ($chat->is_seen == 'Y') {
            $toolTrip .= "&#013; Seen";
        }
        ?>
        <div class="send-chat" title="<?= $toolTrip; ?>">
            <?php echo $subject . $chat->message ?>
        </div>
        <?php
    } else {
        ?>
        <div class="recieve-chat" title="<?= $toolTrip; ?>">
            <?php echo $subject . $chat->message ?>
        </div>
        <?php
    }
}
?>

<?php
$noImgPath = BASE_URL . 'assets/upload/user/profile/no_img.png';
if (count($la_myMessageListAll) == 0) {
    ?>
    <p class="no_data">No user found!</p>
    <?php
}
foreach ($la_myMessageListAll as $row) {
    if ($row->product_id != 0) {
        $userRowId = $row->send_from . "__" . $row->send_to . "__" . $row->product_id . "__pro";
    } else {
        $userRowId = $row->send_from . "__" . $row->send_to . "__" . $row->purchase_id . "__purchase";
    }
    if ($user['id'] != $row->send_to) {
        $name = ucwords($row->to_username);
        $fname = ucwords($row->to_f_name);
        $filename = $row->to_filename;
    } else {
        $name = ucwords($row->from_username);
        $fname = ucwords($row->from_f_name);
        $filename = $row->from_filename;
    }
    if ($filename != '' && (file_exists(UPLOADDIR . "/user/profile/$filename"))) {
        $path = BASE_URL . 'assets/upload/user/profile/' . $filename;
    } else {
        $path = $noImgPath;
    }
    ?>
    <div class="user_list user_list_in_msg_left" id="<?php echo $userRowId ?>">
        <img src="<?php echo $path; ?>" alt="<?php echo ucwords(explode(' ', $name)[0][0] . explode(' ', $name)[1][0]); ?>" />
        <span class="usr-info" title="<?php echo $name . "&#013;" . date('D d M, Y \O\N H:i:s', strtotime($row->created_on)) ?>">
            <span class="name"><?php echo $fname; ?></span>
            <span class="msg"><?php echo $row->message ?></span>
            <!--<span class=""><?php echo $userRowId ?></span>-->
        </span>
    </div>

<?php } ?>

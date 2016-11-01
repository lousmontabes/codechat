<div class="card" id="card<?php echo $i ?>" onclick="showChat(<?php echo $chat['id'] ?>)">
    <div class="row">
        <span class="chatTitle"><?php echo $chat['name'] ?></span>
        <div class="tag"><?php echo $chat['language'] ?></div>
    </div>
    <div class="stats">
        <!--<li class="highlighted">[AMOUNT] new messages</li>-->
        <li><?php echo $chat['messages'] ?> messages</li>
        <!--<li>[AMOUNT] users</li>-->
        <!--<li>[AMOUNT] active right now</li>-->
    </div>
</div>
<div class="card" id="card<?php echo $i ?>" onclick="cardClicked(<?php echo $i ?>, '<?php echo $chat['token'] ?>')">
    <div class="row">
        <span class="chatTitle"><?php echo $chat['name'] ?></span>
        <div class="tag"><?php echo $chat['language'] ?></div>
    </div>
    <div class="stats">
        <!--<li class="highlighted">[AMOUNT] new messages</li>-->
        <li><?php echo $chat['messages'] ?> message<?php if($chat['messages'] > 1){?>s<? } ?></li>
        <!--<li>[AMOUNT] users</li>-->
        <!--<li>[AMOUNT] active right now</li>-->
    </div>
</div>
<div class="card" id="card<?php echo $i ?>">
    <div class="leftside" onclick="cardClicked(<?php echo $i ?>, '<?php echo $chat['token'] ?>')">
        <div class="row">
            <span class="chatTitle"><?php echo $chat['name'] ?></span>
            <div class="languageTag"><?php echo $chat['language'] ?></div>
        </div>
        <div class="stats">
            <!--<li class="highlighted">[AMOUNT] new messages</li>-->
            <li><?php echo $chat['messages'] ?> message<?php if($chat['messages'] > 1 || $chat['messages'] == 0){?>s<? } ?></li>
            <!--<li>[AMOUNT] users</li>-->
            <!--<li>[AMOUNT] active right now</li>-->
        </div>
    </div>
    <div class="rightside">
        <?php if ($isSaved){ ?>
            <img src="/images/remove.svg" width="15" onclick="removeChat(<?php echo $i ?>, <?php echo $chat['id'] ?>)">
        <? }else{ ?>
            <img src="/images/add.svg" width="20" onclick="saveChat(<?php echo $i ?>, <?php $chat['id']?>)">
        <?php } ?>
    </div>
</div>
<?php foreach ($products as $k=>$v): ?>
    <li style="margin-bottom: 10px">
        <label style="width: 50%; display: inline-block" for="nameProduct_<?=$v['id']?>"><?=$v['name']?></label> <button type="button" class="btn btn-default" data-id="<?=$v['id']?>">Добавить</button>
    </li>
<?php endforeach; ?>
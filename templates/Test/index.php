<h1 class="mr-2">Hello! This is <?=strtoupper($flag)?> version</h1>
<?php
echo $this->Form->create(null, [
    'url' => [
        'controller' => 'Test',
        'action' => 'index'
    ]
]);
echo $this->Form->hidden('clear_cookie', ['value' => 'clear']);
echo $this->Form->submit('Clear cookie');
echo $this->Form->end();
?>
<hr>
<?php
echo $this->Form->create(null, [
    'url' => [
        'controller' => 'Test',
        'action' => 'index'
    ]
]);
if($flag == 'b') echo $this->Form->hidden('flag', ['value' => 'b']);
if($flag == 'a') echo $this->Form->hidden('flag', ['value' => 'a']);
$bg_color = $flag == 'a' ? 'green' : 'blue';
$radius = $flag == 'a' ? 5 : 50;
echo $this->Form->submit('Click me', ['style' => 'background: '.$bg_color.'; width:100px;height:100px;padding:0;text-align:center;border-radius:'.$radius.'%;']);
echo $this->Form->end();
?>

<?php if (!defined('THINK_PATH')) exit();?><div id="tb" style="padding:5px;height:auto">
    <input class="easyui-combobox" style="width:100px" id="cb" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="getList()">搜索</a>
</div>
<table id="tt" class="easyui-datagrid" style="width:auto;"
        toolbar="#tb" title="各主题的内容" iconCls="icon-save" fit="true"
        rownumbers="true" pagination="true">
    <thead>
        <tr>
            <th field="a" width="50" formatter="formatAvatar" align="center" halign="center">头像</th>
            <th field="n" width="80" formatter="formatNickname" align="center" halign="center">用户名</th>
            <th field="content" width="560" formatter="formatContent">说的话</th>
            <th field="addtime" width="80" align="center">添加时间</th>
        </tr>
    </thead>
</table>

<script>

function formatAvatar(val, row){
    var url = '/Public/Avatars/' + row.user.fakeid + '.jpg'
    return '<img src="' + url + '" width="30px"/>';
}
function formatNickname(val, row){
    return row.user.nickname;
}
function formatContent(val, row){
    return replaceQQFace(row.content);
}

var baseUrl = "/tjuwechat/index.php?g=Manager&m=Msgwall&a=actlist&activity=";
var activity = -1;
var args = {
    rownumbers : true,
    pagination : true, 
    fitColumns : true,
    columns : [[
        {field:'a', title:'头像', width:50, formatter:formatAvatar, align:'center', halign:'center'}, 
        {field:'n', title:'用户名', width:80, formatter:formatNickname, align:'center', halign:'center'}, 
        {field:'content', title:'大家说的话', width:560, formatter:formatContent}, 
        {field:'addtime', title:'添加时间', width:100}
    ]]
};

$('#cb').combobox({
    url:'/tjuwechat/index.php?g=Manager&m=Activity&a=alist',
    valueField:'id',
    textField:'name',
    onSelect:function(rec){
        activity = rec.id;
    }
});

function getList(){
    args.url = baseUrl + $('#cb').combobox('getValue');;
    $('#tt').datagrid(args);
}
function replaceQQFace(content){
    var qq = ["/::)", "/::~", "/::B", "/::|", "/:8-)", "/::<", "/::$", "/::X", "/::Z", "/::'(", "/::-|", "/::@", "/::P", "/::D", "/::O", "/::(", "/::+", "/:--b", "/::Q", "/::T", "/:,@P", "/:,@-D", "/::d", "/:,@o", "/::g", "/:|-)", "/::!", "/::L", "/::>", "/::,@", "/:,@f", "/::-S", "/:?", "/:,@x", "/:,@@", "/::8", "/:,@!", "/:!!!", "/:xx", "/:bye", "/:wipe", "/:dig", "/:handclap", "/:&-(", "/:B-)", "/:<@", "/:@>", "/::-O", "/:>-|", "/:P-(", "/::'|", "/:X-)", "/::*", "/:@x", "/:8*", "/:pd", "/:<W>", "/:beer", "/:basketb", "/:oo", "/:coffee", "/:eat", "/:pig", "/:rose", "/:fade", "/:showlove", "/:heart", "/:break", "/:cake", "/:li", "/:bome", "/:kn", "/:footb", "/:ladybug", "/:shit", "/:moon", "/:sun", "/:gift", "/:hug", "/:strong", "/:weak", "/:share", "/:v", "/:@)", "/:jj", "/:@@", "/:bad", "/:lvu", "/:no", "/:ok", "/:love", "/:<L>", "/:jump", "/:shake", "/:<O>", "/:circle", "/:kotow", "/:turn", "/:skip", "/:oY", "/:#-0", "/:hiphot", "/:kiss", "/:<&", "/:&>"];
    for (var i = 0; i < qq.length; i++)
    {
        for(var j = 0; j < content.length / 4; j++)
        {
            content = content.replace(qq[i], '<img src="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/' + i + '.gif">');
        }
    }
    return content;
}
</script>
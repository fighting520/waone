<extend name="Public/base"/>
<block name="body">
    <!-- 标题 -->
    <div class="main-title">
        <h2>{$meta_title}({$_total|default=0})</h2>
    </div>
    <!-- 按钮工具栏 -->
    <div class="cf">
        <div class="fl">
            <div class="btn-group">
                <a class="btn" href="{:U('form')}">新 增</a>
            </div>
        </div>
    </div>
    <!-- 数据表格 -->
    <div class="data-table">
        <table>
            <!-- 表头 -->
            <thead>
            <tr>
                <th class="row-selected row-selected"></th>
                <th>标题</th>
                <th>添加时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <!-- 列表 -->
            <tbody>
            <notempty name="list">
                <volist name="list" id="data">
                    <tr>
                        <td></td>
                        <td>{$data.title}</td>
                        <td>{$data.add_time|date="Y-m-d H:i:s",###}</td>
                        <td>{$data.update_time|date="Y-m-d H:i:s",###}</td>
                        <td>
                            <a href="{:U('form',array('id'=>$data['id']))}">编辑</a>
                            <a href="{:U('del',array('id'=>$data['id']))}" class="confirm ajax-get">删除</a>
                        </td>
                    </tr>
                </volist>
                <else/>
                <tr>
                    <td colspan="4" style="text-align: center">暂无相关信息</td>
                </tr>
            </notempty>
            </tbody>
        </table>
    </div>
    <!-- 分页 -->
    <div class="page">{$_page}</div>
</block>
<block name="script">
    <script type="text/javascript">
        //导航高亮
        highlight_subnav("{:U('index')}");
    </script>
</block>
@if($data->isZan(Auth::id()))
    <a href="javascript:void(0)">
      <i class=" fa fa-thumbs-up thumbs-active">{{$data->zans_count}}</i>
    </a>
@else
    <a href="javascript:void(0)" onclick="zan('{{$data->id}}', '{{$url}}', this)">
      <i class=" fa fa-thumbs-up">{{$data->zans_count}}</i>
    </a>
@endif

<script>
  //点赞
  function zan(id, url, self) {
    let that = $(self)
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: url,
      data: {id: id, _token: "{{csrf_token()}}"},
      beforeSend() {
        layer.load()
      },
      success(res) {
        layer.closeAll()
        if (res.errcode) {
          layer.msg(res.errmsg, {time: 2000, icon: 2})
          return false
        }
        let count = parseInt(that.find('i').html());
        count++
        that.find('i').html(count).addClass('thumbs-active')
        layer.msg(res.msg, {time: 1500, icon: 1})
      },
      error(res) {
        layer.closeAll()
        layer.msg('请求失败', {time: 2000, icon: 2})
      }
    })
  }
</script>
  <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
  <script src="/datetimepicker/jquery.js"></script>
  <script src="/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

<div class="form-group {{ $errors->has('hour_warning') ? ' has-error' : '' }}">
    {{ Form::label('view_calendar', trans('admin/warnings/table.view_calendar'), array('class' => 'col-md-3 control-label')) }}
 
    <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23039BE5&amp;ctz=Asia%2FHo_Chi_Minh&amp;src=YmFvYmluaDExMDI5N0BnbWFpbC5jb20&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=bGg2ZjIzbjJ2bWRvYmVtcDVibHI5bmplYW9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=dmkudmlldG5hbWVzZSNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%238E24AA&amp;color=%230B8043&amp;hl=en&amp;title=Calendar%20Snipe%20IT%20by%20Thong" style="border-width:0; margin-top: 10px; margin-left: 15px" width="450" height="350" frameborder="0" scrolling="no"></iframe>

    <iframe src="http://free.timeanddate.com/clock/i6wdspur/n95/szw160/szh160/hoc000/hbw0/hfc09f/cf100/hnc07c/hwc000/facfff/fdi76/mqcfff/mqs4/mql18/mqw4/mqd60/mhcfff/mhs4/mhl5/mhw4/mhd62/mmv0/hhcfff/hhs1/hhb10/hmcfff/hms1/hmb10/hscfff/hsw3" frameborder="0" width="200" height="255"></iframe>



    </div>
</div>
<script>
	jQuery('#datetimepicker1').datetimepicker;
</script>
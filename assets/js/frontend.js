jQuery(function($){
 $('.variations_form').each(function(){
  var $f=$(this),$p=$f.closest('.product'),$u=$p.find('.vs-bqp-unit-price').first(),$b=$p.find('.vs-bqp-box-info').first(),$s=$p.find('.vs-bqp-quantity-suffix[data-vs-bqp-variable="1"]').first(),iu=$u.html(),ib=$b.html();
  $f.on('found_variation',function(e,v){
   if(!v)return;
   if($u.length&&v.vs_bqp_unit_price_html)$u.html(v.vs_bqp_unit_price_html+' <small>'+v.vs_bqp_each_label+'</small>');
   if($b.length){if(v.vs_bqp_is_boxed)$b.html(v.vs_bqp_box_info_html).prop('hidden',false);else $b.empty().prop('hidden',true);}
   if($s.length)$s.prop('hidden',!v.vs_bqp_is_boxed);
  });
  $f.on('reset_data hide_variation',function(){if($u.length)$u.html(iu);if($b.length)$b.html(ib).prop('hidden',false);if($s.length)$s.prop('hidden',true);});
 });
});

jQuery(function($){
 $('.variations_form').each(function(){
  var $f=$(this),$scope=$f.closest('.summary');
  if(!$scope.length)$scope=$f.closest('.product');
  var $u=$scope.find('.vs-bqp-unit-price').first(),$b=$scope.find('.vs-bqp-box-info').first(),$s=$scope.find('.vs-bqp-quantity-suffix[data-vs-bqp-variable="1"]').first(),iu=$u.html(),ib=$b.html();
  function apply(v){
   if(!v)return;
   if($u.length&&v.vs_bqp_unit_price_html)$u.html(v.vs_bqp_unit_price_html+' <small>'+v.vs_bqp_each_label+'</small>');
   if($b.length){if(v.vs_bqp_is_boxed&&v.vs_bqp_box_info_html)$b.html(v.vs_bqp_box_info_html).prop('hidden',false);else $b.empty().prop('hidden',true);}
   if($s.length)$s.prop('hidden',!v.vs_bqp_is_boxed);
  }
  $f.on('found_variation',function(e,v){window.setTimeout(function(){apply(v);},0);});
  $f.on('reset_data hide_variation',function(){if($u.length)$u.html(iu);if($b.length)$b.html(ib).prop('hidden',false);if($s.length)$s.prop('hidden',true);});
  window.setTimeout(function(){$f.trigger('check_variations');},0);
 });
});

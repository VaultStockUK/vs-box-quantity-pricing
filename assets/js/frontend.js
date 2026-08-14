jQuery(function($){
 $('.variations_form').each(function(){
  var $f=$(this),$scope=$f.closest('.summary');
  if(!$scope.length)$scope=$f.closest('.product');
  if(!$scope.length)$scope=$(document.body);

  var $u=$scope.find('.vs-bqp-unit-price').first();
  var $legacy=$scope.find('.vs-bqp-box-info');
  var $s=$scope.find('.vs-bqp-quantity-suffix[data-vs-bqp-variable="1"]').first();
  var iu=$u.html();
  var $live=$scope.find('.vs-bqp-live-box-info').first();

  if(!$live.length&&$u.length){
   $live=$('<small class="vs-bqp-live-box-info" hidden></small>');
   $u.after('<br>',$live);
  }

  function apply(v){
   if(!v)return;

   if($u.length&&v.vs_bqp_unit_price_html){
    $u.html(v.vs_bqp_unit_price_html+' <small>'+v.vs_bqp_each_label+'</small>');
   }

   if(v.vs_bqp_is_boxed&&v.vs_bqp_box_info_html){
    $legacy.prop('hidden',true);
    if($live.length)$live.html(v.vs_bqp_box_info_html).prop('hidden',false);
   }else{
    if($live.length)$live.empty().prop('hidden',true);
    $legacy.prop('hidden',true);
   }

   if($s.length)$s.prop('hidden',!v.vs_bqp_is_boxed);
  }

  function currentVariation(){
   var id=parseInt($f.find('input.variation_id').val(),10);
   var vars=$f.data('product_variations');
   if(!id||!$.isArray(vars))return null;
   for(var i=0;i<vars.length;i++){
    if(parseInt(vars[i].variation_id,10)===id)return vars[i];
   }
   return null;
  }

  function refresh(){
   var v=currentVariation();
   if(v)apply(v);
  }

  $f.on('found_variation',function(e,v){apply(v);});
  $f.on('woocommerce_variation_has_changed',function(){window.setTimeout(refresh,0);});
  $f.on('reset_data hide_variation',function(){
   if($u.length)$u.html(iu);
   if($live.length)$live.empty().prop('hidden',true);
   $legacy.prop('hidden',false);
   if($s.length)$s.prop('hidden',true);
  });

  window.setTimeout(function(){
   $f.trigger('check_variations');
   window.setTimeout(refresh,50);
  },50);
 });
});

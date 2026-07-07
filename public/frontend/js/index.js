let isloadIdex = 0;
$(window).on('scroll  mousemove touchstart',function(){
	try{
		if(!isloadIdex){
			isloadIdex = 1;
			(function($){
				"user strict";
				$.fn.Dqdt_CountDown = function( options ) {
					return this.each(function() {
						new  $.Dqdt_CountDown( this, options );
					});
				}
				$.Dqdt_CountDown = function( obj, options ){
					this.options = $.extend({
						autoStart			: true,
						LeadingZero:true,
						DisplayFormat:"<div><span>%%D%%</span> Days</div><div><span>%%H%%</span> Hours</div><div><span>%%M%%</span> Mins</div><div><span>%%S%%</span> Secs</div>",
						FinishMessage:"Hết hạn",
						CountActive:true,
						TargetDate:null
					}, options || {} );
					if( this.options.TargetDate == null || this.options.TargetDate == '' ){
						return ;
					}
					this.timer  = null;
					this.element = obj;
					this.CountStepper = -1;
					this.CountStepper = Math.ceil(this.CountStepper);
					this.SetTimeOutPeriod = (Math.abs(this.CountStepper)-1)*1000 + 990;
					var dthen = new Date(this.options.TargetDate);
					var dnow = new Date();
					if( this.CountStepper > 0 ) {
						ddiff = new Date(dnow-dthen);
					}
					else {
						ddiff = new Date(dthen-dnow);
					}
					gsecs = Math.floor(ddiff.valueOf()/1000);
					this.CountBack(gsecs, this);
				};
				$.Dqdt_CountDown.fn =  $.Dqdt_CountDown.prototype;
				$.Dqdt_CountDown.fn.extend =  $.Dqdt_CountDown.extend = $.extend;
				$.Dqdt_CountDown.fn.extend({
					calculateDate:function( secs, num1, num2 ){
						var s = ((Math.floor(secs/num1))%num2).toString();
						if ( this.options.LeadingZero && s.length < 2) {
							s = "0" + s;
						}
						return s;
					},
					CountBack:function( secs, self ){
						if (secs < 0) {
							self.element.innerHTML = '<div class="lof-labelexpired"> '+self.options.FinishMessage+"</div>";
							$('.block-flashsale').hide();
							return;
						}
						clearInterval(self.timer);
						DisplayStr = self.options.DisplayFormat.replace(/%%D%%/g, self.calculateDate( secs,86400,100000) );
						DisplayStr = DisplayStr.replace(/%%H%%/g, self.calculateDate(secs,3600,24));
						DisplayStr = DisplayStr.replace(/%%M%%/g, self.calculateDate(secs,60,60));
						DisplayStr = DisplayStr.replace(/%%S%%/g, self.calculateDate(secs,1,60));
						self.element.innerHTML = DisplayStr;
						if (self.options.CountActive) {
							self.timer = null;
							self.timer =  setTimeout( function(){
								self.CountBack((secs+self.CountStepper),self);
							},( self.SetTimeOutPeriod ) );
						}
					}
				});
				$(document).ready(function(){
					$('[data-countdown="countdown"]').each(function(index, el) {
						var $this = $(this);
						var $date = $this.data('date').split("-");
						$this.Dqdt_CountDown({
							TargetDate:$date[0]+"/"+$date[1]+"/"+$date[2]+" "+$date[3]+":"+$date[4]+":"+$date[5],
							DisplayFormat:"<div class=\"block-timer\"><p>%%D%%</p><span>Ngày</span></div><div class=\"block-timer\"><p>%%H%%</p><span>Giờ</span></div><div class=\"block-timer\"><p>%%M%%</p><span>Phút</span></div><div class=\"block-timer\"><p>%%S%%</p><span>Giây</span></div>",
							FinishMessage: "Chương trình đã hết hạn"
						});
					});
				});
			})(jQuery);
			$(".not-dqtab").each( function(e){
				var $this1 = $(this);
				var datasection = $this1.closest('.not-dqtab').attr('data-section');
				$this1.find('.tabs-title li:first-child').addClass('current');
				var view = $this1.closest('.not-dqtab').attr('data-view');
				$this1.find('.tab-content').first().addClass('current');
				var droptab = $(this).find('.tab-desktop');
				$this1.find('.tabs-title.ajax li').click(function(){
					var $this2 = $(this),
						tab_id = $this2.attr('data-tab'),
						url = $this2.attr('data-url'),
						img = $this2.attr('data-image'),
						title = $this2.attr('data-title');
					var etabs = $this2.closest('.e-tabs');
					$('.image-tab img').attr('src',img);
					$('.image-tab').attr('href',img);
					$('.image-tab').attr('title',title);
					etabs.find('.tab-viewall').attr('href',url);
					etabs.find('.tabs-title li').removeClass('current');
					etabs.find('.tab-content').removeClass('current');
					$this2.addClass('current');
					etabs.find("."+tab_id).addClass('current');
					if(!$this2.hasClass('has-content')){
						$this2.addClass('has-content');		
						getContentTab(url,"."+ datasection+" ."+tab_id,view);
					}
				});
			});
			function getContentTab(url,selector){
				url = url+"?view=ajaxload4";
				var loading = '<div style="width: 100%; margin-top: 20px" class="text-center">Đang tải dữ liệu...</div>';
				var fill = $(selector);
				$.ajax({
					type: 'GET',
					url: url,
					beforeSend: function() {
						$(selector).html(loading);
					},
					success: function(data) {
						var content = $(data);
						setTimeout(function(){
							$(selector).html(content.html());
							awe_lazyloadImage();
							
							
							
							if (typeof window.refreshCompareMarks === 'function') {
								window.refreshCompareMarks();
							}
							
							$(selector+' .add_to_cart').off('click.fioCart').on('click.fioCart', function(e){
								e.preventDefault();
								if (typeof window.fioAddToCartFromForm === 'function') {
									window.fioAddToCartFromForm($(this));
									return;
								}
								var $this = $(this);
								var form = $this.parents('form');
								$.ajax({
									type: 'POST',
									url: form.data('add-cart-url') || form.attr('action') || '/add-to-cart',
									async: false,
									data: form.serialize(),
									dataType: 'json',
									success: function(res) {
										if (typeof window.fioAddToCartDone === 'function') {
											window.fioAddToCartDone(res);
										}
									},
									cache: false
								});
							});
							$(document).ready(function () {
								var modal = $('.quickview-product');
								var btn = $('.quick-view');
								var span = $('.quickview-close');
								btn.click(function () {
									modal.show();
								});
								span.click(function () {
									modal.hide();
								});
								$(window).on('click', function (e) {
									if ($(e.target).is('.modal')) {
										modal.hide();
									}
								});
							});

						},300);
					},
					dataType: "html"
				});
			};
		}
	}catch(e){
		console.log(e);
	}
});
function callbackFuncGroup(sectionName) {
	setTimeout(function(){
		awe_lazyloadImage();
		
		
		
		if (typeof window.refreshCompareMarks === 'function') {
			window.refreshCompareMarks();
		}
		
		$(`.${sectionName} .add_to_cart`).off('click.fioCart').on('click.fioCart', function(e){
			e.preventDefault();
			if (typeof window.fioAddToCartFromForm === 'function') {
				window.fioAddToCartFromForm($(this));
				return;
			}
			var $this = $(this);
			var form = $this.parents('form');
			$.ajax({
				type: 'POST',
				url: form.data('add-cart-url') || form.attr('action') || '/add-to-cart',
				async: false,
				data: form.serialize(),
				dataType: 'json',
				success: function(res) {
					if (typeof window.fioAddToCartDone === 'function') {
						window.fioAddToCartDone(res);
					}
				},
				cache: false
			});
		});
		$(document).ready(function () {
			var modal = $('.quickview-product');
			var btn = $('.quick-view');
			var span = $('.quickview-close');
			btn.click(function () {
				modal.show();
			});
			span.click(function () {
				modal.hide();
			});
			$(window).on('click', function (e) {
				if ($(e.target).is('.modal')) {
					modal.hide();
				}
			});
		});
		if(window.BPR && window.BPR.loadBadges){
			window.BPR.initDomEls()
			window.BPR.loadBadges()
		}
	},200);

}
function lazyBlockProduct(sectionName, rootMargin, callback) {
	var section = $('.' + sectionName);
	var template = $('script[data-template="' + sectionName + '"]').html();
	var observer = new IntersectionObserver(function(entries) {
		entries.forEach(function(entry) {
			if (entry.isIntersecting) {
				$('div[data-section="' + sectionName + '"]', entry.target).html(template);
				observer.unobserve(entry.target);
				callbackFuncGroup(sectionName);
				if (typeof callback === 'function') {
					callback();
					console.log(sectionName,"");
				}
			}
		});
	}, { rootMargin: rootMargin });
	observer.observe(section.get(0));
}
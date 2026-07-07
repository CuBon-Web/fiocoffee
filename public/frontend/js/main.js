window.awe = window.awe || {};
awe.init = function () {
	awe.showPopup();
	awe.hidePopup();	
};
let isload = 0;
$(window).on('scroll  mousemove touchstart',function(){
	try{
		if(!isload){
			isload = 1
			function awe_showLoading(selector) {
				var loading = $('.loader').html();
				$(selector).addClass("loading").append(loading); 
			}  window.awe_showLoading=awe_showLoading;
			function awe_hideLoading(selector) { 
				$(selector).removeClass("loading"); 
				$(selector + ' .loading-icon').remove();
			}  window.awe_hideLoading=awe_hideLoading;
			function awe_showPopup(selector) {
				$(selector).addClass('active');
			}  window.awe_showPopup=awe_showPopup;
			function awe_hidePopup(selector) {
				$(selector).removeClass('active');
			}  window.awe_hidePopup=awe_hidePopup;
			awe.hidePopup = function (selector) {
				$(selector).removeClass('active');
			}
			function awe_convertVietnamese(str) { 
				str= str.toLowerCase();
				str= str.replace(/Ă |Ă¡|áº¡|áº£|Ă£|Ă¢|áº§|áº¥|áº­|áº©|áº«|Äƒ|áº±|áº¯|áº·|áº³|áºµ/g,"a"); 
				str= str.replace(/Ă¨|Ă©|áº¹|áº»|áº½|Ăª|á»|áº¿|á»‡|á»ƒ|á»…/g,"e"); 
				str= str.replace(/Ă¬|Ă­|á»‹|á»‰|Ä©/g,"i"); 
				str= str.replace(/Ă²|Ă³|á»|á»|Ăµ|Ă´|á»“|á»‘|á»™|á»•|á»—|Æ¡|á»|á»›|á»£|á»Ÿ|á»¡/g,"o"); 
				str= str.replace(/Ă¹|Ăº|á»¥|á»§|Å©|Æ°|á»«|á»©|á»±|á»­|á»¯/g,"u"); 
				str= str.replace(/á»³|Ă½|á»µ|á»·|á»¹/g,"y"); 
				str= str.replace(/Ä‘/g,"d"); 
				str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
				str= str.replace(/-+-/g,"-");
				str= str.replace(/^\-+|\-+$/g,""); 
				return str; 
			} window.awe_convertVietnamese=awe_convertVietnamese;
			function awe_category(){
				$('.nav-category .fa-angle-right').click(function(e){
					$(this).toggleClass('fa-angle-down fa-angle-right');
					$(this).parent().toggleClass('active');
				});
				$('.nav-category .fa-angle-down').click(function(e){
					$(this).toggleClass('fa-angle-right');
					$(this).parent().toggleClass('active');
				});
			} window.awe_category=awe_category;
			
			
			var wDWs = $(window).width();
			if (wDWs < 1199) {
				$('.vertical-menu-category .title').on('click', function(){
					$('.vertical-menu-category').toggleClass('active');
				})
			}
			
			$(document).ready(function(){
				// Header search autocomplete: see /frontend/js/search-header.js
				function getItemSearchCompare(name, smartjsonpro){
					return fetch(`https://${window.location.hostname}/search?q=name:(*${name}*)&view=${smartjsonpro}&type=product`)
						.then(res => res.json())
						.catch(err => console.error(err))
				}
				$('.header_compare input[type="text"]').bind('keyup change', function(e){
					let termcom = $(this).val().trim();
					let datacom = '';
					var resultboxcom = '';
					if(termcom.length > 1) {
						async function goawaySearchcom() {
							datacom = await getItemSearchCompare(termcom, 'smartjsonpro');
							setTimeout(function(){
								var sizeDatacom = Object.keys(datacom).length;
								if(sizeDatacom > 0) {
									Object.keys(datacom).forEach(function(key) {
										if (datacom[key].compare_price != 0 && datacom[key].type != '') {
											resultboxcom += `<div class="product-smart"><a class="image_thumb" href="${datacom[key].url}" title="${datacom[key].name}"><img width="480" height="480" class="lazyload loaded" src="${datacom[key].image}" data-src="${datacom[key].image}" alt="${datacom[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name"><a href="${datacom[key].url}">${datacom[key].name}</a></h3><div class="price-box"><span class="price">${datacom[key].price}</span><span class="compare-price">${datacom[key].compare_price}</span></div><a href="javascript:void(0)" class="setCompare btn-views js-compare-product-add" data-compare="${datacom[key].alias}" data-type="${datacom[key].type}" tabindex="0" title="So sánh"><i></i> </a></div></div>`
										} else if(datacom[key].compare_price != 0 && datacom[key].type == ''){
											resultboxcom += `<div class="product-smart"><a class="image_thumb" href="${datacom[key].url}" title="${datacom[key].name}"><img width="480" height="480" class="lazyload loaded" src="${datacom[key].image}" data-src="${datacom[key].image}" alt="${datacom[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name"><a href="${datacom[key].url}">${datacom[key].name}</a></h3><div class="price-box"><span class="price">${datacom[key].price}</span><span class="compare-price">${datacom[key].compare_price}</span></div><a href="javascript:void(0)" class="setCompare btn-views js-compare-product-add" data-compare="${datacom[key].alias}" data-type="default-type" tabindex="0" title="So sánh"><i></i></a></div></div>`
										}else if (datacom[key].compare_price == 0 && datacom[key].type != ''){
											resultboxcom += `<div class="product-smart"><a class="image_thumb" href="${datacom[key].url}" title="${datacom[key].name}"><img width="480" height="480" class="lazyload loaded" src="${datacom[key].image}" data-src="${datacom[key].image}" alt="${datacom[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name"><a href="${datacom[key].url}">${datacom[key].name}</a></h3><div class="price-box"><span class="price">${datacom[key].price}</span></div><a href="javascript:void(0)" class="setCompare btn-views js-compare-product-add" data-compare="${datacom[key].alias}" data-type="${datacom[key].type}" tabindex="0" title="So sánh"><i></i></a></div></div>`
										}else{
											resultboxcom += `<div class="product-smart"><a class="image_thumb" href="${datacom[key].url}" title="${datacom[key].name}"><img width="480" height="480" class="lazyload loaded" src="${datacom[key].image}" data-src="${datacom[key].image}" alt="${datacom[key].name}" data-was-processed="true"></a><div class="product-info"><h3 class="product-name"><a href="${datacom[key].url}">${datacom[key].name}</a></h3><div class="price-box"><span class="price">${datacom[key].price}</span></div><a href="javascript:void(0)" class="setCompare btn-views js-compare-product-add" data-compare="${datacom[key].alias}" data-type="default-type" tabindex="0" title="So sánh"><i></i></a></div></div>`
										}
									});
									$('.list-compare').html(resultboxcom);
									if (typeof window.refreshCompareMarks === 'function') {
										window.refreshCompareMarks();
									}
								} else {
									$('.list-compare').html('<div class="not-pro">Không có thấy kết quả tìm kiếm</div>');
								}
							}, 200);
						}
						goawaySearchcom();
					}else {
						$('.list-compare').html('');
					}
				});
				
			});
			
			
			if (wDWs < 767) {
				$('.footer-click h4').click(function(e){
					console.log('check')
					$(this).toggleClass('active').next().slideToggle();
					$(this).next('ul').toggleClass("current");
				});
			}
			$('.btn-close').click(function() {
				$(this).parents('.dropdown').toggleClass('open');
			}); 
			$('.ul_collections li > svg').click(function(){
				$(this).parent().toggleClass('current');
				$(this).toggleClass('fa-angle-down fa-angle-right');
				$(this).next('ul').slideToggle("fast");
				$(this).next('div').slideToggle("fast");
			});
			awe_backtotop();
			$(document).on('click','.overlay, .close-window, .btn-continue, .fancybox-close', function() {   
				awe.hidePopup('.awe-popup'); 
				setTimeout(function(){
					$('.loading').removeClass('loaded-content');
				},500);
				return false;
			})
			$('.menu-bar, #btn-menu-mobile-fix').on('click', function(){
				$('.opacity_menu').addClass('current');
				$('.header-nav').addClass('current');
			});
			$('.opacity_menu').on('click', function(){
				$('.header-nav').removeClass('current');
				$('.opacity_menu').removeClass('current');
				$('.menu_mega').removeClass('current');
			});
			$('.title_menu').on('click', function(){
				$(this).closest('.header-nav').removeClass('current');
				$(this).closest('.menu_mega').removeClass('current');
				$('.opacity_menu').removeClass('current');
			});
			$(document).on('click.fioNav', '.header-nav--fio .nav-item__toggle', function (e) {
				e.preventDefault();
				e.stopPropagation();
				var $btn = $(this);
				var $item = $btn.closest('.nav-item');
				var isOpen = $item.hasClass('is-open');

				$item.toggleClass('is-open');
				$btn.attr('aria-expanded', !isOpen);
			});
			$(document).on('click.fioNavMobile', '#nav-mobile .nav-mobile__toggle', function (e) {
				e.preventDefault();
				e.stopPropagation();
				var $btn = $(this);
				var $item = $btn.closest('.nav-item');
				var isOpen = $item.hasClass('is-open');

				$item.toggleClass('is-open');
				$btn.attr('aria-expanded', !isOpen);
			});
			if (wDWs < 991) {
				$('.item_big li .fa').click(function(e){
					if ($(this).closest('.header-nav--fio').length) {
						return;
					}
					if($(this).hasClass('current')) {
						$(this).closest('ul').find('li, .fa').removeClass('current');
					} else {
						$(this).closest('ul').find('li, .fa').removeClass('current');
						$(this).closest('li').addClass('current');
						$(this).addClass('current');
					}
				});
				$('#nav-mobile li .open_mnu').click(function(e){
					if ($(this).closest('#nav-mobile .nav-mobile__toggle').length) {
						return;
					}
					if($(this).hasClass('current')) {
						$(this).closest('ul').find('li, .open_mnu').removeClass('current');
					} else {
						$(this).closest('ul').find('li, .open_mnu').removeClass('current');
						$(this).closest('li').addClass('current');
						$(this).addClass('current');
					}
				});
			}
			awe_category();
			$('.dropdown-toggle').click(function() {
				$(this).parent().toggleClass('open'); 	
			}); 
			$(document).ready(function() {
				var margin_left = 0;
				$('#prev').on('click', function(e) {
					e.preventDefault();
					animateMargin( 190 );
				});
				$('#next').on('click', function(e) {
					e.preventDefault();
					animateMargin( -190 );
				});
				const animateMargin = ( amount ) => {
					margin_left = Math.min(0, Math.max( getMaxMargin(), margin_left + amount ));
					$('ul.item_big').animate({
						'margin-left': margin_left
					}, 300);
				};
				const getMaxMargin = () => 
				$('ul.item_big').parent().width() - $('ul.item_big')[0].scrollWidth;
			})
			var wDWs = $(window).width();
			function awe_category(){
				$('.nav-category .fa-angle-right').click(function(e){
					$(this).toggleClass('fa-angle-down fa-angle-right');
					$(this).parent().toggleClass('active');
				});
				$('.nav-category .fa-angle-down').click(function(e){
					$(this).toggleClass('fa-angle-right');
					$(this).parent().toggleClass('active');
				});
			} window.awe_category=awe_category;
			function awe_backtotop() { 
				$(window).scroll(function() {
					$(this).scrollTop() > 200 ? $('.backtop').addClass('show') : $('.backtop').removeClass('show')
				});
				$('.backtop').click(function() {
					return $("body,html").animate({
						scrollTop: 0
					}, 800), !1
				});
			} window.awe_backtotop=awe_backtotop;

			if (wDWs > 992) {
				function horizontalNav() {
					return {
						wrapper: $('.header-menu-des'),
						navigation: $('.header-menu-des .header-nav'),
						item: $('.header-menu-des .header-nav .nav-item'),
						totalStep: 0,
						onCalcNavOverView: function(){
							let itemHeight = this.item.eq(0).outerWidth(),
								lilength = this.item.length,
								total = 0;
							for (var i = 0; i < lilength; i++) {
								itemHeight = this.item.eq(i).outerWidth();
								total += itemHeight;
							}
							return Math.ceil(total)
						},
						onCalcTotal: function(){
							let  navHeight = this.navigation.width();
							return Math.ceil(navHeight)
						},
						init:function(){
							this.totalStep = this.onCalcNavOverView();
							this.totalTo = this.onCalcTotal();
							if(this.totalStep > this.totalTo){
								$('.control-menu').addClass("d-lg-block");

							} 
						}
					}	
				}
			}
			$(document).ready(function ($) {
				if(window.matchMedia('(min-width: 992px)').matches){
					horizontalNav().init()
				}
			});
			var swipertext = new Swiper('.topbar-slider', {
				autoplay: {
					delay: 4000,
				},
			});

			theme.alert = (function() {
				var $alert = $('#js-global-alert'),
					$title = $('#js-global-alert .alert-heading'),
					$content = $('#js-global-alert .alert-content'),
					close = '#js-global-alert .close';
				var timeoutID = null;
				$(document).on('click', close, function() {
					$alert.removeClass('active');
				});

				function createAlert(title, mess, time, type) {
					var alertTitle = title || '',
						showTime = time || 3000,
						alertClass = type;

					$alert.removeClass('alert-success').removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-primary');
					$alert.addClass(alertClass);
					$title.html(title);
					$content.html(mess);
					$alert.addClass('active');
					if (timeoutID) {
						clearTimeout(timeoutID);
					}

					timeoutID = setTimeout(function() {
						$alert.removeClass('active');
					}, showTime);
				}

				return {
					new: createAlert
				};
			})();
			$('body').on('click','.btn-show-popup-compare',function(e){
				$('.sidebarAllMainCompare').addClass('active');
			})
			$('body').on('click','.closeSidebar',function(e){
				e.preventDefault();
				$('.sidebarAllMainCompare').removeClass('active');
			})
		}
	}catch(e){
		console.log(e);
	}
});

var beanComprare = {};
beanComprare.General = {
	init: function() {
		beanComprare.Compare.init();
	},
}
beanComprare.Compare = {
	init: function() {
		this.compareShow();
		this.compareClose();
		this.setCompareProductLoop();
		this.compareProduct(3, 5);
		this.removeCompare();
	},
	compareShow:function(){
		$('body').on('click','.setCompare:not(.active)',function(e){
			e.preventDefault();
			var phand = [];
			var typeP = [];
			var handle = $(this).data('compare');
			var countCompare = $('.js-compare-count').text();
			var typeOn = $(this).data('type');
			if (countCompare == '0') {
				typeP = [typeOn];
				Cookies.set('compare_type', typeP, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}
			var storedType = Cookies.getJSON('compare_type');
			if (storedType.includes(typeOn)) {
				$('.sidebarAllMainCompare').addClass('active');
			}else {
			}
		})
	},
	compareClose:function(){
		$('body').on('click','.closeSidebar',function(e){
			e.preventDefault();
			$('.sidebarAllMainCompare').removeClass('active');
		})
	},
	setCompareProductLoop: function() {
		var self = this;
		$('body').on('click', '.setCompare:not(.active)', function(e) {
			e.preventDefault();
			var phand = [];
			var typeP = [];
			var handle = $(this).data('compare');
			var countCompare = $('.js-compare-count').text();
			var typeOn = $(this).data('type');
			if (countCompare == '0') {
				typeP = [typeOn];
				Cookies.set('compare_type', typeP, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}
			var storedType = Cookies.getJSON('compare_type');
			if (storedType.includes(typeOn)) {
				if (countCompare < '3') {
					if (document.cookie.indexOf('compare_products') !== -1) {
						var las = Cookies.getJSON('compare_products');
						if ($.inArray(handle, las) === -1) {
							phand = [handle];
							for (var i = 0; i < las.length; i++) {
								phand.push(las[i]);
								if (phand.length > 15) {
									break;
								}
							}
							Cookies.set('compare_products', phand, {
								expires: 15,
								sameSite: 'None',
								secure: true
							});
						}
					} else {
						phand = [handle];
						Cookies.set('compare_products', phand, {
							expires: 15,
							sameSite: 'None',
							secure: true
						});
					}
					self.compareProduct(3, 5);
					self.activityCompare();
					var SuccessText = "Bạn vừa thêm 1 sản phẩm vào mục so sánh thành công bấm <a style='color:#2196f3' href='/so-sanh-san-pham'>vào đây</a> để tới trang so sánh";
					var alertClass = 'alert-success';
					theme.alert.new('So sánh sản phẩm',SuccessText,3000,alertClass);
					awe_lazyloadImage();
				} else {
					var ErrorText = 'Bạn chỉ có thể so sánh tối đa 3 sản phẩm';
					var alertClass = 'alert-danger';
					theme.alert.new('So sánh sản phẩm',ErrorText,3000,alertClass);
				}
			}else {
				var ErrorText = 'Sản phẩm so sánh phải cùng loại';
				var alertClass = 'alert-danger';
				theme.alert.new('So sánh sản phẩm',ErrorText,3000,alertClass);
			}
		})
	},
	compareProduct: function(items, margin) {
		var self = this;
		if (document.cookie.indexOf('compare_products') !== -1) {
			$('.sidebarAllMainCompare .sidebarAllBody').html('');
			var last_compare_pro_array = Cookies.getJSON('compare_products');
			self.activityCompare();
			var recentview_promises = [];
			var recentview_promisescus = [];
			for (var i = 0; i < 3; i++) {
				if (typeof last_compare_pro_array[i] == 'string') {
					var promise = new Promise(function(resolve, reject) {
						$.ajax({
							url: '/products/' + last_compare_pro_array[i] + '?view=compare',
							async: false,
							success: function(product) {
								resolve({
									error: false,
									data: product
								});
							},
							error: function(err) {
								if (err.status === 404) {
									try {
										var u = ((this.url.split('?'))[0]).replace('/products/', '');
										resolve({
											error: true,
											handle: u
										});
									} catch (e) {
										resolve({
											error: false,
											data: ''
										})
									}
								} else {
									resolve({
										error: false,
										data: ''
									});
								}
							}
						})
					});
					recentview_promises.push(promise);
					recentview_promisescus.push(promise);
				}
				else {
					var boxnone = {
						error : true,
						data: "<div class='item-compare itemMainCompareNone'><div class='item-compare-wrap'><i class='icImageCompareNew'></i> <p>Thêm sản phẩm </p></div> </div>",
					};
					recentview_promises.push(boxnone);
					setTimeout(function() {
						let videos = document.querySelectorAll('.itemMainCompareNone');
						let popupVideo = document.querySelector('.popup_compare');
						let close_vd = document.querySelectorAll('.close_compare');
						videos.forEach(v => v.addEventListener('click', function(e){
							e.preventDefault();
							popupVideo.classList.add('open');
						}));
						close_vd.forEach(v => v.addEventListener('click', function(e){
							e.preventDefault();
							popupVideo.classList.remove('open');
						}))
					}, 500)
				}

			}
			Promise.all(recentview_promisescus).then(function(values) {
				if (values.length > 0){
					$('.site-header__compare').removeClass('d-none');
				}else {
					$('.site-header__compare').addClass('d-none');
					$('.sidebarAllMainCompare').removeClass('active');
				}
				setTimeout(function() {
					$('.js-compare-count').html(values.length);
					$('.compareCount').html(values.length);
				}, 500)
			});
			Promise.all(recentview_promises).then(function(values) {
				var x = [];
				i
				$.each(values, function(i, v) {
					if (v.error) {
						x.push(v.handle);
						$('.sidebarAllMainCompare .sidebarAllBody').append(v.data);
					} else {
						$('.sidebarAllMainCompare .sidebarAllBody').append(v.data);
						$('.sidebarAllMainCompare .sidebarAllBody').show();
						awe_lazyloadImage();
					}
				});
			});
			if ($('#pageCompare').length >= 1) {
				var selfPage = $('#pageCompare').find('table');
				for (var i = 0; i < 3; i++) {
					if (typeof last_compare_pro_array[i] == 'string') {
						var promise = new Promise(function(resolve, reject) {
							$.ajax({
								url: '/products/' + last_compare_pro_array[i] + '?view=compare_json',
								async: false,
								success: function(product) {
									var parseData = $.parseJSON(product);
									selfPage.find(`tr.image td:nth-child(${i + 2})`).html(parseData.image ? `<img class="img-fluid" src="${parseData.image}" alt="${parseData.title}"/>` : "//bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif");
									selfPage.find(`tr.title td:nth-child(${i + 2})`).html(`<h3><a href="${parseData.url}">${parseData.title}</a></h3>`);
									selfPage.find(`tr.price td:nth-child(${i + 2})`).html(parseData.price);
									selfPage.find(`tr.available td:nth-child(${i + 2})`).html(parseData.available);
									selfPage.find(`tr.type td:nth-child(${i + 2})`).html(parseData.type);
									selfPage.find(`tr.vendor td:nth-child(${i + 2})`).html(parseData.vendor);
									selfPage.find(`tr.description td:nth-child(${i + 2})`).html(parseData.description);
									awe_lazyloadImage();
								},
								error: function(err) {
									$('#alertError').modal('show').find('.modal-body').html('Xin lỗi, có vấn đề khi thực hiện so sánh, vui lòng thử lại sau!');
								}
							})
						});
						recentview_promises.push(promise);
					}
				}
			}
			setTimeout(function(){
				var countLenght = $('.js-compare-count').text();
				if (countLenght == '0') {
					$('.null-table').removeClass('d-none').addClass('d-block');
					$('.compare-table').addClass('d-none').removeClass('d-block');
					$('.sidebarAllMainCompare .sidebarAllBody').html('<div class="note">Bạn chưa có sản phẩm nào để so sánh hãy thêm vào nhé</div>');
				}else {
					$('.null-table').addClass('d-none').removeClass('d-block');
					$('.compare-table').removeClass('d-none').addClass('d-block');
				}
				if (countLenght > 0){
					$('.site-header__compare').removeClass('d-none');
				}else {
					$('.site-header__compare').addClass('d-none');
					$('.sidebarAllMainCompare').removeClass('active');
				}
				$('.js-compare-count').html(countLenght);
				$('.compareCount').html(countLenght);
			},700)
		}else{
			$('.null-table').removeClass('d-none').addClass('d-block');
		}
	},
	activityCompare: function() {
		var last_wishlist_pro_array = Cookies.getJSON('compare_products');
		$.each(last_wishlist_pro_array, function(i, v){
			$('.setCompare[data-compare="' + v + '"]').addClass('active').attr('title', 'Đã so sánh');
		})
		setTimeout(function() {
			if ($('.itemMainCompare').length > 0){
				$('.site-header__compare').removeClass('d-none');
			}else {
				$('.site-header__compare').addClass('d-none');
				$('.sidebarAllMainCompare').removeClass('active');
			}
			$('.js-compare-count').html($('.itemMainCompare').length);
			$('.compareCount').html($('.itemMainCompare').length);
		}, 500)
		setTimeout(function() {
			if ($('.sidebarAllMainCompare .sidebarAllBody').html() ==  ''){
				$('.sidebarAllMainCompare').removeClass('active');
			}
		}, 1000)

	},
	removeCompare: function() {
		var self = this;
		$('body').on('click', '.itemMainCompare .removeItem', function(e) {
			e.preventDefault();
			var phand = [];
			var handle = $(this).attr('data-compare');
			var countCompare = $('.js-compare-count').text();
			$('a[data-compare="' + handle + '"]').removeClass('active').attr('title', 'Thêm vào so sánh');
			if (document.cookie.indexOf('compare_products') !== -1) {
				var las = Cookies.getJSON('compare_products');
				var flagIndex = $.inArray(handle, las);
				las.splice(flagIndex, 1)
				Cookies.set('compare_products', las, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			} else {
				Cookies.set('compare_products', phand, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}
			self.compareProduct(3, 5);
			if (countCompare == '0') {
				$('.site-header__compare').addClass('d-none');
				$('.sidebarAllMainCompare').removeClass('active');
				Cookies.set('compare_products', phand, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}		
		})
		$('body').on('click', '.itemMainCompare .removeItem2', function(e) {
			e.preventDefault();
			var phand = [];
			var handle = $(this).attr('data-compare');
			var countCompare = $('.js-compare-count').text();
			$('a[data-compare="' + handle + '"]').removeClass('active').attr('title', 'Thêm vào so sánh');
			if (document.cookie.indexOf('compare_products') !== -1) {
				var las = Cookies.getJSON('compare_products');
				var flagIndex = $.inArray(handle, las);
				las.splice(flagIndex, 1)
				Cookies.set('compare_products', las, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			} else {
				Cookies.set('compare_products', phand, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}

			self.compareProduct(3, 5);
			location.reload();
			if (countCompare == '0') {
				Cookies.set('compare_products', phand, {
					expires: 15,
					sameSite: 'None',
					secure: true
				});
			}		
		})
	}
}
// So sánh sản phẩm: dùng /frontend/js/compare.js (Laravel session)
// beanComprare.Compare.init();
// $(document).ready(function(){
// 	beanComprare.Compare.compareProduct();
// });

window.fioAddToCartDone = function (res) {
	if (res && res.cart_count != null) {
		$('.count_item_pr').text(res.cart_count);
	}
	var $notify = $('#qv-cart-notify');
	if ($notify.length) {
		$notify.text((res && res.message) || 'Đã thêm vào giỏ hàng').addClass('show');
		clearTimeout(window._fioCartNotifyTimer);
		window._fioCartNotifyTimer = setTimeout(function () {
			$notify.removeClass('show');
		}, 3000);
	}
};

window.fioAddToCartFromForm = function ($btn) {
	var $form = $btn.closest('form');
	if (!$form.length || $btn.prop('disabled') || $btn.hasClass('is-loading')) {
		return;
	}

	$btn.addClass('is-loading');

	$.ajax({
		url: $form.data('add-cart-url') || $form.attr('action') || '/add-to-cart',
		method: 'POST',
		dataType: 'json',
		data: $form.serialize()
	}).done(function (res) {
		window.fioAddToCartDone(res);
	}).fail(function (xhr) {
		var message = 'Không thể thêm sản phẩm vào giỏ hàng.';
		if (xhr.responseJSON) {
			if (xhr.responseJSON.message) {
				message = xhr.responseJSON.message;
			} else if (xhr.responseJSON.errors) {
				var firstError = Object.values(xhr.responseJSON.errors)[0];
				if (Array.isArray(firstError) && firstError.length) {
					message = firstError[0];
				}
			}
		}
		alert(message);
	}).always(function () {
		$btn.removeClass('is-loading');
	});
};

$(document).on('click', '.item_product_main--fio .add_to_cart', function (e) {
	e.preventDefault();
	e.stopImmediatePropagation();
	window.fioAddToCartFromForm($(this));
});
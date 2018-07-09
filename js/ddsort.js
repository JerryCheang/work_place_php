;(function( $ ){
	/**
	 * Author: https://github.com/Barrior
	 * 
	 * DDSort: drag and drop sorting.
	 * @param {Object} options
	 *        target[string]: 		鍙€夛紝jQuery浜嬩欢濮旀墭閫夋嫨鍣ㄥ瓧绗︿覆锛岄粯璁�'li'
	 *        cloneStyle[object]: 	鍙€夛紝璁剧疆鍗犱綅绗﹀厓绱犵殑鏍峰紡
	 *        floatStyle[object]: 	鍙€夛紝璁剧疆鎷栧姩鍏冪礌鐨勬牱寮�
	 *        down[function]: 		鍙€夛紝榧犳爣鎸変笅鏃舵墽琛岀殑鍑芥暟
	 *        move[function]: 		鍙€夛紝榧犳爣绉诲姩鏃舵墽琛岀殑鍑芥暟
	 *        up[function]: 		鍙€夛紝榧犳爣鎶捣鏃舵墽琛岀殑鍑芥暟
	 */
	$.fn.DDSort = function( options ){
		var $doc = $( document ),
			fnEmpty = function(){},

			settings = $.extend( true, {

				down: fnEmpty,
				move: fnEmpty,
				up: fnEmpty,

				target: 'li',
				cloneStyle: {
					'background-color': '#eee'
				},
				floatStyle: {
					//鐢ㄥ浐瀹氬畾浣嶅彲浠ラ槻姝㈠畾浣嶇埗绾т笉鏄疊ody鐨勬儏鍐电殑鍏煎澶勭悊锛岃〃绀轰笉鍏煎IE6锛屾棤濡�
					'position': 'fixed',
					'box-shadow': '10px 10px 20px 0 #eee',
					'webkitTransform': 'rotate(2deg)',
					'mozTransform': 'rotate(2deg)',
					'msTransform': 'rotate(2deg)',
					'transform': 'rotate(2deg)'
				}

			}, options );

		return this.each(function(){

			var that = $( this ),
				height = 'height',
				width = 'width';

			if( that.css( 'box-sizing' ) == 'border-box' ){
				height = 'outerHeight';
				width = 'outerWidth';
			}

			that.on( 'mousedown.DDSort', settings.target, function( e ){
				//鍙厑璁搁紶鏍囧乏閿嫋鍔�
				if( e.which != 1 ){
					return;
				}
				
				//闃叉琛ㄥ崟鍏冪礌澶辨晥
				var tagName = e.target.tagName.toLowerCase();
				if( tagName == 'input' || tagName == 'textarea' || tagName == 'select' ){
					return;
				}
				
				var THIS = this,
					$this = $( THIS ),
					offset = $this.offset(),
					disX = e.pageX - offset.left,
					disY = e.pageY - offset.top,
				
					clone = $this.clone()
						.css( settings.cloneStyle )
						.css( 'height', $this[ height ]() )
						.empty(),
						
					hasClone = 1,

					//缂撳瓨璁＄畻
					thisOuterHeight = $this.outerHeight(),
					thatOuterHeight = that.outerHeight(),

					//婊氬姩閫熷害
					upSpeed = thisOuterHeight,
					downSpeed = thisOuterHeight,
					maxSpeed = thisOuterHeight * 3;
				
				settings.down.call( THIS );
				
				$doc.on( 'mousemove.DDSort', function( e ){
					if( hasClone ){
						$this.before( clone )
							.css( 'width', $this[ width ]() )
							.css( settings.floatStyle )
							.appendTo( $this.parent() );
							
						hasClone = 0;
					}
					
					var left = e.pageX - disX,
						top = e.pageY - disY,
						
						prev = clone.prev(),
						next = clone.next().not( $this );
					
					$this.css({
						left: left,
						top: top
					});
					
					//鍚戜笂鎺掑簭
					if( prev.length && top < prev.offset().top + prev.outerHeight()/2 ){
							
						clone.after( prev );
						
					//鍚戜笅鎺掑簭
					}else if( next.length && top + thisOuterHeight > next.offset().top + next.outerHeight()/2 ){
						
						clone.before( next );

					}

					/**
					 * 澶勭悊婊氬姩鏉�
					 * that鏄甫鐫€婊氬姩鏉＄殑鍏冪礌锛岃繖閲岄粯璁や互涓簍hat鍏冪礌鏄繖鏍风殑鍏冪礌锛堟甯告儏鍐靛氨鏄繖鏍凤級锛屽鏋滀娇鐢ㄨ€呬簨浠跺鎵樼殑鍏冪礌涓嶆槸杩欐牱鐨勫厓绱狅紝閭ｄ箞闇€瑕佹彁渚涙帴鍙ｅ嚭鏉�
					 */
					var thatScrollTop = that.scrollTop(),
						thatOffsetTop = that.offset().top,
						scrollVal;
					
					//鍚戜笂婊氬姩
					if( top < thatOffsetTop ){

						downSpeed = thisOuterHeight;
						upSpeed = ++upSpeed > maxSpeed ? maxSpeed : upSpeed;
						scrollVal = thatScrollTop - upSpeed;

					//鍚戜笅婊氬姩
					}else if( top + thisOuterHeight - thatOffsetTop > thatOuterHeight ){

						upSpeed = thisOuterHeight;
						downSpeed = ++downSpeed > maxSpeed ? maxSpeed : downSpeed;
						scrollVal = thatScrollTop + downSpeed;
					}

					that.scrollTop( scrollVal );

					settings.move.call( THIS );

				})
				.on( 'mouseup.DDSort', function(){
					
					$doc.off( 'mousemove.DDSort mouseup.DDSort' );
					
					//click鐨勬椂鍊欎篃浼氳Е鍙憁ouseup浜嬩欢锛屽姞涓婂垽鏂樆姝㈣繖绉嶆儏鍐�
					if( !hasClone ){
						clone.before( $this.removeAttr( 'style' ) ).remove();
						settings.up.call( THIS );
					}
				});
				
				return false;
			});
		});
	};

})( jQuery );

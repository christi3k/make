/* global Backbone, jQuery, _ */
var oneApp = oneApp || {};

(function (window, Backbone, $, _, oneApp) {
	'use strict';

	oneApp.BannerSlideView = oneApp.ItemView.extend({
		template: '',
		className: 'ttfmake-banner-slide ttfmake-banner-slide-open',

		events: function() {
			return _.extend({}, oneApp.ItemView.prototype.events, {
				'click .ttfmake-banner-slide-remove': 'onSlideRemove',
				'click .ttfmake-banner-slide-toggle': 'toggleSection',
				'click .ttfmake-media-uploader-add': 'onMediaOpen',
				'overlayClose': 'onOverlayClose',
				'color-picker-change': 'onColorPickerChange',
				'view-ready': 'onViewReady',
			});
		},

		initialize: function (options) {
			this.template = _.template(ttfMakeSectionTemplates['banner-item']);
		},

		render: function () {
			this.$el.html(this.template(this.model))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'));
			return this;
		},

		onViewReady: function(e) {
			e.stopPropagation();

			oneApp.initColorPicker(this);
		},

		onOverlayClose: function(e, textarea) {
			this.model.set('content', $(textarea).val());
			this.$el.trigger('model-item-change');
		},

		onColorPickerChange: function(e, data) {
			e.stopPropagation();

			this.model.set(data.modelAttr, data.color);
			this.$el.trigger('model-item-change');
		},

		onSlideRemove: function (evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttfmake-banner-slides'),
				$orderInput = $('.ttfmake-banner-slide-order', $stage);

			oneApp.removeOrderValue(this.model.get('id'), $orderInput);

			// Fade and slide out the section, then cleanup view
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.$el.trigger('slide-remove', this);
				this.remove();
			}.bind(this));
		},

		toggleSection: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$section = $this.parents('.ttfmake-banner-slide'),
				$sectionBody = $('.ttfmake-banner-slide-body', $section),
				$input = $('.ttfmake-banner-slide-state', this.$el);

			if ($section.hasClass('ttfmake-banner-slide-open')) {
				$sectionBody.slideUp(oneApp.options.closeSpeed, function() {
					$section.removeClass('ttfmake-banner-slide-open');
					$input.val('closed');
				});
			} else {
				$sectionBody.slideDown(oneApp.options.openSpeed, function() {
					$section.addClass('ttfmake-banner-slide-open');
					$input.val('open');
				});
			}
		}
	});
})(window, Backbone, jQuery, _, oneApp);
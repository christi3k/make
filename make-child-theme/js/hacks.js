import React from 'react';
import { __ } from '@wordpress/i18n';
import { dispatch, select, subscribe } from '@wordpress/data';

class MakeGutenberg {
	init() {
		this.subscribe();
	}

	subscribe() {
		subscribe( 'core/editor', function() {
			console.log('h');
		} );
	}
}

const makeGutenberg = new MakeGutenberg();
makeGutenberg.init();
import { decodeLink } from '../../admin/encoder';
import deprecated from './deprecated';
import edit from './edit';

import '../../../css/blocks/blocks.scss';

const { __ } = wp.i18n;
const {
	registerBlockType,
} = wp.blocks;
const {
	RichText,
} = wp.editor;

registerBlockType( 'visual-link-preview/link', {
	title: __( 'Visual Link Preview' ),
	description: __( 'A visual link block for internal or external links.' ),
	icon: 'id',
	keywords: ['vlp'],
	category: 'widgets',
	supportHTML: false,

	attributes: {		
		title: {
			type: 'string',
			source: 'html',
			selector: 'h3',
		},
		summary: {
			type: 'string',
			source: 'html',
			selector: '.summary',
		},
		image_id: {
			type: 'number',
		},
		image_url: {
			type: 'string',
			source: 'attribute',
			selector: 'img',
			attribute: 'src',
		},
		type: {
			type: 'string',
			default: false,
		},
		post: {
			type: 'number',
			default: 0,
		},
		post_label: {
			type: 'string',
			default: '',
		},
		url: {
			type: 'string',
			default: '',
		},
		template: {
			type: 'string',
			default: 'use_default_from_settings',
		},
		nofollow: {
			type: 'boolean',
		},
		new_tab: {
			type: 'boolean',
		},
		encoded: {
			type: 'string',
		},
	},

	transforms: {
        from: [
            {
                type: 'shortcode',
                tag: 'visual-link-preview',
                attributes: {
					title: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.title;
                        },
					},
					summary: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
							let summary = decoded.summary;

							// Replace line breaks with <br>.
							summary = summary.replace( new RegExp( '\r?\n','g' ), '<br />' );

							// Surround summary with paragraph tags or it won't work in the RichText component.
                            return '<p>' + summary + '</p>';
                        },
                    },
					image_id: {
                        type: 'number',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
							const image_id = parseInt(decoded.image_id);
                            return image_id ? image_id : null;
                        },
					},
					image_url: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.image_url;
                        },
                    },
                    type: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.type;
                        },
					},
					post: {
                        type: 'number',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return parseInt(decoded.post);
                        },
					},
					post_label: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.post_label;
                        },
                    },
					url: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.url;
                        },
					},
					template: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.template;
                        },
					},
					nofollow: {
                        type: 'boolean',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.nofollow;
                        },
					},
					new_tab: {
                        type: 'boolean',
                        shortcode: ( { named: { encoded = '' } } ) => {
							const decoded = decodeLink(encoded);
                            return decoded.new_tab;
                        },
					},
					encoded: {
                        type: 'string',
                        shortcode: ( { named: { encoded = '' } } ) => {
                            return encoded;
                        },
                    },
                },
			},
			{
                type: 'block',
				blocks: [ 'core/shortcode', 'core/paragraph' ],
				isMatch: ( props ) => {
					const text = props.hasOwnProperty( 'text' ) ? props.text : props.content;

					const re = wp.shortcode.regexp('[visual-link-preview ');
					return re.test(text);
				},
				transform: ( props ) => {
					const text = props.hasOwnProperty( 'text' ) ? props.text : props.content;

					return wp.blocks.rawHandler({
						HTML: '<p>' + text + '</p>',
						mode: 'BLOCKS'
					});
				},
            },
        ]
    },
	edit: edit,
	save( { className, attributes } ) {
		return (
			<div className={ className }>
				{
					attributes.image_url && (
						<img className="vlp-image" src={ attributes.image_url } />
					)
				}
				<RichText.Content tagName="h3" value={ attributes.title } />
				<RichText.Content tagName="div" className="summary" value={ attributes.summary } />
			</div>
		);
	},
	deprecated: deprecated,
} );
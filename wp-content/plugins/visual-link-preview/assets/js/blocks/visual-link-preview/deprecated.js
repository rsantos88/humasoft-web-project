const {
	renderToString,
} = wp.element;

export default [
    {
        attributes: {		
            title: {
                type: 'array',
                source: 'children',
                selector: 'h3',
            },
            summary: {
                type: 'array',
                source: 'children',
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
                default: 'internal',
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
            encoded: {
                type: 'string',
            },
        },

        migrate( attributes ) {
            return {
                ...attributes,
                title: renderToString( attributes.title ),
                summary: renderToString( attributes.summary ),
            }
        },

        save( { className, attributes } ) {
            return (
                <div className={ className }>
                    {
                        attributes.image_url && (
                            <img className="vlp-image" src={ attributes.image_url } />
                        )
                    }
                    <h3>
                        { attributes.title }
                    </h3>
                    <div className="summary">
                        { attributes.summary }
                    </div>
                </div>
            );
        },
    },
];
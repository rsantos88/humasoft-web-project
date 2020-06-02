const { __ } = wp.i18n;
const {
	InspectorControls,
    PlainText,
} = wp.editor;
const {
	Button,
    PanelBody,
    SelectControl,
    ToggleControl
} = wp.components;
const {
	Component,
} = wp.element;

import ImageSelect from './ImageSelect';

export default class extends Component {
    render() {
        const { attributes, setAttributes } = this.props;

        const changeLinkButton = (
            <div style={{ marginTop: 15 }}>
                <Button
                    isDefault
                    onClick={() => {
                        setAttributes({
                            type: false,
                            post: 0,
                        });
                    }}
                >Change Link</Button>
            </div>
        );

        let templateOptions = [{
            value: 'use_default_from_settings',
            label: __( 'Use Default from Settings' ),
        }];
        for (let template in vlp_blocks.templates) {
            templateOptions.push({
                value: template,
                label: vlp_blocks.templates[template].name,
            });
        }

        return (
            <InspectorControls>
                {
                    'internal' === attributes.type
                    ?
                    <PanelBody title={ __( 'Internal Link' ) }>
                        <a href={ `${ vlp_blocks.edit_link }${ attributes.post}` } target="_blank"> { attributes.post_label || __( 'Edit Post' ) }</a>
                        { changeLinkButton }
                    </PanelBody>
                    :
                    <PanelBody title={ __( 'External Link' ) }>
                        <a href={ attributes.url } target="_blank"> { attributes.url }</a>
                        { changeLinkButton }
                    </PanelBody>
                }
                <PanelBody title={ __( 'Content' ) }>
                    <strong><PlainText
                        placeholder={ __( 'Title', 'dynamic-widget-content' ) }
                        value={ attributes.title }
                        onChange={ ( value ) => setAttributes( { title: value } ) }
                    /></strong>
                    <PlainText
                        placeholder={ __( 'Summary', 'dynamic-widget-content' ) }
                        value={ attributes.summary }
                        onChange={ ( value ) => setAttributes( { summary: value } ) }
                    />
                    <ImageSelect {...this.props} />
                </PanelBody>
                <PanelBody title={ __( 'Options' ) }>
                    <ToggleControl
                        label={ __( 'Open link in new tab' ) }
                        checked={ attributes.new_tab }
                        onChange={ () => setAttributes( { new_tab: ! attributes.new_tab } ) }
                    />
                    <ToggleControl
                        label={ __( 'Nofollow Link' ) }
                        help={ attributes.nofollow ? __( 'The rel="nofollow" attribute will get added to the link.' ) : __( 'The rel="nofollow" attribute will not get added to the link.' ) }
                        checked={ attributes.nofollow }
                        onChange={ () => setAttributes( { nofollow: ! attributes.nofollow } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Style' ) }>
                    <SelectControl
                        label={ __( 'Template' ) }
                        value={ attributes.template }
                        options={ templateOptions }
                        onChange={ ( value ) => {
                            setAttributes( {
                                template: value
                            } );
                        } }
                    />
                    <a href={ vlp_blocks.settings_link } target="_blank">{ __( 'Change template styling' ) }</a>
                </PanelBody>
            </InspectorControls>
        )
    }
}
const { __ } = wp.i18n;
const { Button } = wp.components;
const { Component } = wp.element;

import PostSelect from './PostSelect';

export default class ChooseType extends Component {
    constructor() {
        super( ...arguments );
    }

    getPage(type) {
        this.props.setAttributes( {
            type,
            nofollow: 'external' === type ? true : false,
            new_tab: 'external' === type ? true : false,
        } );
    }

    render() {
        const { attributes, setAttributes } = this.props;

        return (
            <div className="vlp-block-choosetype">
                <div className="vlp-block-choosetype-container">
                    <label>{ __( 'Select a post on your website:') }</label>
                    <PostSelect
                        value={ {
                            id: attributes.post,
                            text: attributes.post_label,
                        } }
                        onChangeField={ (option) => {
                            setAttributes( {
                                post: option.id,
                                post_label: option.text,
                            }, this.getPage('internal') );
                        } }
                    />
                </div>
                <div className="vlp-block-choosetype-container">
                    <label for="vlp-field-url">{ __( 'Or add a link to an external URL:') }</label>
                    <input
                        id="vlp-field-url"
                        type="text"
                        value={attributes.url}
                        onChange={(e) => setAttributes( { url: e.target.value } )}
                        onKeyPress={(e) => {
                            if ( 'Enter' === e.key ) {
                                this.getPage('external');
                            }
                        }}
                    />
                    <Button 
                        isPrimary
                        disabled={ 0 === attributes.url.length }
                        onClick={() => this.getPage('external')}
                    >
                    { __( 'Use this URL' ) }
                    </Button>
                </div>
            </div>
        )
    }
}
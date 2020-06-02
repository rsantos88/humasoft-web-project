import React, { Component } from 'react';
import PropTypes from 'prop-types';

import Api from '../../shared/Api';
export default class FieldImage extends Component {

    constructor(props) {
        super(props);
        this.wp_media = false;
    }

    onAddImage(e) {
        e.preventDefault();

        if (!this.wp_media) {
            this.wp_media = wp.media({
                title: vlp_admin.text.media_title,
                button: {
                    text: vlp_admin.text.media_button
                },
                multiple: false
            });
        }

        this.wp_media.on('select', function() {
            var attachment = this.wp_media.state().get('selection').first().toJSON();

            this.props.onChangeField({
                id: attachment.id,
                url: attachment.url,
            });
        }.bind(this));

        this.wp_media.open();
    }

    onSaveImage() {
        Api.saveImage(this.props.url).then(( { success, data } ) => {
            if ( success ) {
                this.props.onChangeField({
                    id: data.image_id,
                    url: data.image_url,
                });
            }
        });
    }

    onRemoveImage(e) {
        e.preventDefault();

        this.props.onChangeField({
            id: 0,
            url: '',
        });
    }

    render() {
        return (
            <div className="vlp-form-line vlp-link-post-required">
                <div className="vlp-form-label">
                    <label htmlFor="vlp-link-image-id">Image</label>
                </div>
                <div className="vlp-form-input">
                {
                    this.props.value !== 0
                    ?
                    <div>
                        <button type="button" id="vlp-link-image-remove" className="button" onClick={this.onRemoveImage.bind(this)}>Remove Image</button>
                        {
                            this.props.value === -1 && this.props.url
                            ?
                            <div><a href="#" onClick={this.onSaveImage.bind(this)}>Save image locally</a></div>
                            :
                            null
                        }
                    </div>
                    :
                    <button type="button" id="vlp-link-image-add" className="button" onClick={this.onAddImage.bind(this)}>Add Image</button>
                }
                </div>
                <div className="vlp-form-description">Image for the preview.</div>
            </div>
        );
    }
}

FieldImage.propTypes = {
    value: PropTypes.number.isRequired,
    url: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}
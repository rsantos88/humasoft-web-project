import React, { Component } from 'react';
import PropTypes from 'prop-types';

import Api from '../../shared/Api';
import FieldImage from './field-image';
import FieldPost from './field-post';
import FieldSummary from './field-summary';
import FieldTemplate from './field-template';
import FieldTitle from './field-title';
import FieldType from './field-type';
import FieldUrl from './field-url';
import Preview from './preview';

export default class Form extends Component {
    
    constructor(props) {
        super(props);
    }

    onChangePost(option) {
        this.props.onUpdateLink({
            post: option.id,
            post_label: option.text,
        });

        Api.getContentFromPost( option.id ).then(
            ({ data }) => {
                this.props.onUpdateLink({
                    ...data,
                });
            }
        );
    }

    onChangeURL(e) {
        const url = e.target.value;
        this.props.onUpdateField('url', url);

        // TODO Debounce.
        Api.getContentFromUrl( url ).then(
            ({ data }) => {
                this.props.onUpdateLink({
                    ...data,
                });
            }
        );
    }

    onChangeImage(image) {
        this.props.onUpdateLink({
            image_id: image.id,
            image_url: image.url,
        });
    }
    
    render() {

        let post_option = {
            id: this.props.link.post,
            text: this.props.link.post_label,
        };

        return (
            <div className="vlp-form">
                <div className="vlp-form-section">
                    <FieldType value={this.props.link.type} onChangeField={(value) => this.props.onUpdateField('type', value)} />
                </div>
                <div className="vlp-form-section">
                    {
                        this.props.link.type === 'internal'
                        ?
                        <FieldPost
                            value={post_option}
                            onChangeField={this.onChangePost.bind(this)}
                        />
                        :
                        <FieldUrl value={this.props.link.url} onChangeField={this.onChangeURL.bind(this)} />
                    }
                    {
                        this.props.link.type === 'external' || this.props.link.post > 0
                        ?
                        [<FieldImage value={this.props.link.image_id} url={this.props.link.image_url} onChangeField={this.onChangeImage.bind(this)} key={0} />,
                        <FieldTitle value={this.props.link.title} onChangeField={(e) => this.props.onUpdateField('title', e.target.value)} key={1} />,
                        <FieldSummary value={this.props.link.summary} onChangeField={(e) => this.props.onUpdateField('summary', e.target.value)} key={2} />]
                        :
                        ''
                    }
                </div>
                <div className="vlp-form-section">
                    <FieldTemplate value={this.props.link.template} onChangeField={(value) => this.props.onUpdateField('template', value)} />
                </div>
                <Preview
                    link={this.props.link}
                    encoded={this.props.encoded}
                    needPreviewUpdate={this.props.needPreviewUpdate}
                    onFinishedPreview={this.props.onFinishedPreview}
                />
            </div>
        );
    }
}

Form.propTypes = {
    link: PropTypes.object.isRequired,
    encoded: PropTypes.string.isRequired,
    onUpdateField: PropTypes.func.isRequired,
    needPreviewUpdate: PropTypes.bool.isRequired,
    onFinishedPreview: PropTypes.func.isRequired,
}
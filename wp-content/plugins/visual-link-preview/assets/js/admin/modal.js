import React, { Component } from 'react';
import PropTypes from 'prop-types';

import Form from './form';

import '../../css/admin/modal.scss';

export default class Modal extends Component {

    constructor(props){
        super(props);
        this.state = {
            link: {},
            editorId: '',
            shortcodeId: 0,
            isOpen: false,
            isUpdating: false,
            needPreviewUpdate: false,
        };
    }

    resetLink() {
        this.setState({
            link: {
                type: 'internal',
                post: 0,
                post_label: '',
                url: '',
                image_id: 0,
                image_url: '',
                title: '',
                summary: '',
                template: 'use_default_from_settings',
            }
        });
    };
    
    onUpdateLink(fields) {
        this.setState({
            link: {
                ...this.state.link,
                ...fields,
            },
            needPreviewUpdate: true,
        });
    }

    onUpdateField(field, value) {
        let link = { ...this.state.link };
        link[field] = value;

        this.setState({
            link,
            needPreviewUpdate: true,
        });
    }

    onFinishedPreview() {
        this.setState({
            needPreviewUpdate: false,
        });
    }

    getEncodedLink() {
        return this.props.encodeLink(this.state.link);
    }

    componentWillMount() {
        this.resetLink();
    }

    open(editorId, args = {}) {
        let nextState = {
            editorId,
            isOpen: true,
        };

        if (args.encoded) {
            nextState.link = this.props.decodeLink(args.encoded)
            nextState.isUpdating = true;
        }

        if (args.shortcode_id) {
            nextState.shortcodeId = args.shortcode_id;
        }

        this.setState(nextState);
    }

    save() {
        const encoded = this.getEncodedLink();
        const shortcode = '[visual-link-preview encoded="' + encoded + '"]';

        if (this.state.isUpdating) {
            this.props.replaceShortcodeInEditor(this.state.editorId, this.state.shortcodeId, shortcode);
        } else {
            this.props.addTextToEditor(this.state.editorId, shortcode);
        }

        this.close();
    }

    close() {
        this.resetLink();
        this.setState({
            editorId: '',
            shortcodeId: 0,
            isOpen: false,
            isUpdating: false,
            needPreviewUpdate: true,
        });
    }

    render() {
        if (!this.state.isOpen) {
            return null;
        }

        return (
            <div className="vlp-modal-container" id="vlp-modal-container">
                <div className="vlp-modal">
                    <button type="button" className="button-link vlp-modal-close" onClick={this.close.bind(this)}><span className="vlp-modal-icon"><span className="screen-reader-text">Close Modal</span></span></button>
            
                    <div className="vlp-modal-content">
                        <div className="vlp-frame">
                            <div className="vlp-frame-title">
                                <h1>Visual Link Preview</h1>
                            </div>
                            <div className="vlp-frame-content">
                                <Form
                                    link={this.state.link}
                                    encoded={this.getEncodedLink()}
                                    onUpdateLink={this.onUpdateLink.bind(this)}
                                    onUpdateField={this.onUpdateField.bind(this)}
                                    needPreviewUpdate={this.state.needPreviewUpdate}
                                    onFinishedPreview={this.onFinishedPreview}
                                />
                            </div>
            
                            <div className="vlp-frame-toolbar">
                                <div className="vlp-toolbar">
                                    <div className="vlp-toolbar-primary">
                                        <button type="button" className="button vlp-button button-primary button-large vlp-button-action" onClick={this.save.bind(this)}>{ this.state.isUpdating ? 'Update' : 'Insert' }</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="vlp-modal-backdrop"></div>
            </div>
        )
    }
}

Modal.propTypes = {
    encodeLink: PropTypes.func.isRequired,
    decodeLink: PropTypes.func.isRequired,
    addTextToEditor: PropTypes.func.isRequired,
    replaceShortcodeInEditor: PropTypes.func.isRequired,
}
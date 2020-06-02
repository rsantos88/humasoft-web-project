const { __ } = wp.i18n;
const {
    MediaUpload,
} = wp.editor;
const {
	Button,
} = wp.components;
const {
	Component,
} = wp.element;

import Api from '../../../shared/Api';

export default class ImageSelect extends Component {
    constructor() {
        super( ...arguments );

        this.state = {
            savingImage: false,
        }
    }

    onSaveImage() {
        this.setState({
            savingImage: true,
        }, () => {
            Api.saveImage(this.props.attributes.image_url).then(( { success, data } ) => {
                this.setState({
                    savingImage: false,
                }, () => {
                    if ( success ) {
                        this.props.setAttributes( { image_id: data.image_id, image_url: data.image_url } );
                    }
                });
            });
        });
    }

    render() {
        const { attributes, setAttributes } = this.props;

        return (
            <div style={{ marginTop: 15 }}>
                <MediaUpload
                    onSelect={
                        ( media ) => {
                            setAttributes( { image_id: media.id, image_url: media.url } );
                        }
                    }
                    type="image"
                    value={ attributes.image_id }
                    render={ ( { open } ) => (
                        <Button
                            isDefault
                            onClick={ open }
                        >{ attributes.image_id ? __( 'Change Image' ) : __( 'Choose Image' ) }</Button>
                    ) }
                /> {
                    attributes.image_id
                    ?
                    <Button
                        isDefault
                        onClick={ () => {
                            setAttributes({
                                image_id: null,
                                image_url: null
                            });
                        } }
                    >{ __( 'Remove Image' ) }</Button>
                    :
                    null
                } {
                    -1 === attributes.image_id && attributes.image_url
                    &&
                    <Button
                        isLink
                        disabled={this.state.savingImage}
                        onClick={this.onSaveImage.bind(this)}
                    >{ __( 'Save image locally' ) }</Button>
                }
            </div>
        );
    }
}
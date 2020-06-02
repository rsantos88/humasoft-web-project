const { __ } = wp.i18n;
const {
    Disabled,
    ServerSideRender,
    Placeholder,
    Spinner,
} = wp.components;
const {
	Fragment,
	Component,
} = wp.element;

import { decodeLink, encodeLink } from '../../../admin/encoder';
import Api from '../../../shared/Api';
import Sidebar from './Sidebar';
import ChooseType from './ChooseType';

export default class extends Component {
    constructor() {
        super( ...arguments );

        this.initialiazing = true;
        this.initialType = false;

        this.state = {
            gettingContent: false,
        };
    }

    componentDidMount() {
        const encoded = this.props.attributes.hasOwnProperty( 'encoded') ? this.props.attributes.encoded : false;

        if ( encoded ) {
            const decoded = decodeLink( encoded );

            this.initialType = decoded.type;

            this.props.setAttributes({
                ...this.props.attributes,
                ...decoded,
            });
        }
    }

    componentWillUpdate(nextProps) {
        let link = Object.assign({}, nextProps.attributes);
        delete link.encoded;

        // Add class to link object.
        link.custom_class = nextProps.className;

        const encoded = encodeLink(link);

        if(this.props.attributes.encoded !== encoded) {
            this.props.setAttributes({
                encoded: encoded
            });
        }

        let compareValue = this.props.attributes.type;
        if ( this.initialiazing ) {
            compareValue = this.initialType;
            this.initialiazing = false;
        }

        if ( false === compareValue && compareValue !== nextProps.attributes.type ) {
            this.getContent(nextProps.attributes);
        }
    }

    getContent(attributes) {
        this.setState({
            gettingContent: true,
        }, () => {
            const value = 'internal' === attributes.type ? attributes.post : attributes.url;
            Api.getContent( attributes.type, value ).then(
                ({ data }) => {
                    this.props.setAttributes({
                        ...data,
                    }, this.setState({ gettingContent: false }));
                }
            );
        });
    }

    render() {
        const { className } = this.props;

        // Try to fix problem introduced in 1.3.1.
        let { attributes } = this.props;
        let { summary } = attributes;

        if ( summary && '&lt;p&gt;' === summary.substr(0,9) ) {
            summary = summary.replace(/&lt;/gm,'<',);
            summary = summary.replace(/&gt;/gm,'>');
            attributes.summary = summary;
        }

        // Default values for nofollow and new_tab.
        if ( ! attributes.hasOwnProperty( 'nofollow' ) ) {
            attributes.nofollow = 'external' === attributes.type ? true : false;
        }
        if ( ! attributes.hasOwnProperty( 'new_tab' ) ) {
            attributes.new_tab = 'external' === attributes.type ? true : false;
        }

        return (
            <Fragment>
                <div className={ className }>
                    {
                        ! attributes.type
                        ?
                        <ChooseType {...this.props} />
                        :
                        <Fragment>
                            {
                                this.state.gettingContent
                                ?
                                <Placeholder><Spinner/></Placeholder>
                                :
                                <Fragment>
                                    <Sidebar {...this.props} />
                                    {
                                        attributes.image_id || attributes.title || attributes.summary
                                        ?
                                        <Disabled>    
                                            <ServerSideRender
                                                block="visual-link-preview/link"
                                                attributes={ {
                                                    encoded: attributes.encoded
                                                } }
                                            />
                                        </Disabled>
                                        :
                                        <Placeholder>
                                            { __( 'Set content for this link in the sidebar.' ) }
                                        </Placeholder>
                                    }
                                </Fragment>
                            }
                        </Fragment>
                    }
                </div>
            </Fragment>
        )
    }
}
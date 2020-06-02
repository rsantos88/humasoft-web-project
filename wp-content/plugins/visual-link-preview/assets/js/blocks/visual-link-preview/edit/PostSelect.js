const { __ } = wp.i18n;
const { Component } = wp.element;
import Api from '../../../shared/Api';
import AsyncSelect from 'react-select/lib/Async';

export default class PostSelect extends Component {
    constructor() {
        super( ...arguments );
    }

    getOptions(input) {
        if (!input) {
			return Promise.resolve({ options: [] });
        }

        return Api.searchPosts(input).then(( { data } ) => data.posts_with_id );
    }

    render() {
        const value = this.props.value.id === 0 ? null : this.props.value;

        return (
            <AsyncSelect
                placeholder={ __( 'Select a post or page' ) }
                noOptionsMessage={ () => __( 'Start typing to search...' ) }
                value={value}
                onChange={this.props.onChangeField}
                getOptionValue={({id}) => id}
                getOptionLabel={({text}) => text}
                loadOptions={this.getOptions.bind(this)}
                clearable={false}
            />
        );
    }
}
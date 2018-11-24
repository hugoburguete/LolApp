import React from 'react';

export default class SearchForm extends React.Component {
    render() {
        return (
            <div className="pos-r">
                <div className="vertical-horizontal-center">
                	{this.props.children}
                </div>
            </div>
        );
    }
}
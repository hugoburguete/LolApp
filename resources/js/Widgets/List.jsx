import React from 'react';

function List(props) {
	const items = props.items;
	const listItems = items.map((item, index) => 
        <ListItem 
            key={item.id} 
            index={index} 
            data={item}
            onListItemSelected={props.onListItemSelected}>
            { props.itemRenderer(index, item) }
        </ListItem>
    );
	return (
	    <div className="list">
			{ listItems }
	    </div>
	);
}

class ListItem extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			'open': false,
		};
	}

    getClasses() {
        var classes = ['list-item'];
        if (this.state.open) classes.push('list-item-toggled');
        return classes.join(' ');
    }

	onListItemSelected(index, data) {
		this.setState(prevState => {
			open: !prevState.open
		});
		this.props.onListItemSelected(index, data);
	}

	render() {
		return (
			<div
				className={this.getClasses()}
				onClick={this.onListItemSelected(this.props.index, this.props.data)}>
				{this.props.children}
			</div>
		);
	}
}

export {
	List,
	ListItem,
};
import React, { Component } from 'react';

export default class Filter extends Component {
    constructor(props) {
        super();

        this.state = props;

        this.props = props.callback;
    }

    componentWillMount() {
        this.setState({
            categories: [],
            tags: [],
            dateFrom: '2010-05-05',
            dateTo: '2020-06-06'
        });
    }

    selectCategories(event) {
        let options = event.target.options;
        let value = [];
        for (let i = 0, l = options.length; i < l; i++) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        this.setState({
            categories: value
        });
    }
    selectTags(event) {
        let options = event.target.options;
        let value = [];
        for (let i = 0, l = options.length; i < l; i++) {
            if (options[i].selected) {
                value.push(options[i].value);
            }
        }
        this.setState({
            tags: value
        });
    }

    setFilters() {
        this.props.callback({
            categoriesId: this.state.categories,
            tagsId: this.state.tags,
            dateFrom: this.state.dateFrom,
            dateTo: this.state.dateTo
        });
    }

    selectDateFrom(e) {
        this.setState({
            dateFrom: e.target.value
        });
    }
    selectDateTo(e){
        this.setState({
            dateTo: e.target.value
        });
    }

    render() {
        const categories = this.state.filters.categories;
        const tags = this.state.filters.tags;

        return(
            <div className="filter">
                <select multiple={true} className='filter__category' onChange={this.selectCategories.bind(this)}>
                    {
                        categories.map(category => (
                            <option key={category.id} value={category.id}>{category.name}</option>
                        ))
                    }
                </select>
                <select multiple={true} className='filter__tag' onChange={this.selectTags.bind(this)}>
                    {
                        tags.map(tag => (
                            <option key={tag.id} value={tag.id}>{tag.name}</option>
                        ))
                    }
                </select>
                <input type="date" onChange={this.selectDateFrom.bind(this)}/>
                <input type="date" onChange={this.selectDateTo.bind(this)}/>
                <button onClick={this.setFilters.bind(this)}>Search</button>
            </div>
        );
    }
}
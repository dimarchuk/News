import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Axios from 'axios';

import './Tags.css';

import { apiUrl } from "../../Helpers/index";

import Pagination from '../Pagination/Pagination';

export default class Tags extends Component {
    constructor(props) {
        super();

        this.props = props;
        this.state = {};
    }

    componentWillMount() {
        this.getTags();
    }

    getTags(page = 1) {
        const tagId = this.props.match.params.id;

        Axios.get(`${apiUrl}tag/${tagId}?page=${page}`)
            .then(response => {
                this.setState({
                    tags: response.data
                });
            })
            .catch(error => console.log(error))
    }

    render() {
        const tags = this.state.tags;
        if (!tags) {
            return(
                <div className="tags">
                    <span>Loading...</span>
                </div>
            );
        } else {
            return (
                <div className="tags">
                    <div className="tags__name">
                        <span>#{tags.category_name}</span>
                    </div>
                    <div className="tags__list-article">
                        {
                            tags.articles.map(tag => (
                                <div key={tag.id} className="tag">
                                    <Link className="tags__title" to={`/article/${tag.id}`}>
                                        <span>{tag.title}</span>
                                    </Link>
                                </div>
                            ))
                        }
                    </div>
                    <div className="tags__pagination">
                        <Pagination activePage={tags.currentPage} pagination={tags.countPages} callback={this.getTags.bind(this)} />
                    </div>
                </div>
            );
        }
    }
}
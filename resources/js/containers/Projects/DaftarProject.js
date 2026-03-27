import React, { useState, useEffect, useMemo, useCallback } from "react";
import ReactDOM from "react-dom";
import DataTable, { memoize } from "react-data-table-component";
import DataTableExtensions from "react-data-table-component-extensions";
import axios from "axios";
import Container from "../../components/Layout/Container";
import BreadCrumb from "../../components/BreadCrumb";
import Card from "../../components/Layout/Card";
import { BREADCRUMB_DAFTAR_PROJECT } from "./constants";
import _ from "lodash";
import _d from "datedash";
import "react-data-table-component-extensions/dist/index.css";

export function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

export function formatDate(date) {
  if (_.isEmpty(date)) return "";
  const cdate = new Date(date);
  return _d.date(cdate, "/");
  // return `${cdate.getDate()}/${cdate.getMonth()}/${cdate.getFullYear()}`;
}

/*
  <th scope="col">No.</th>
  <th>No Reg</th>
  <th>Keterangan</th>
  <th>Sumber Proyek</th>
  <th>Tanggal Mulai Proyek</th>
  <th>Tanggal Akhir Proyek</th>
  <th>Nilai Proyek</th>
  <th>Status</th>
  */

function DaftarProject(props) {
  const [data, setData] = useState([]);
  const [isDataLoading, setIsDataLoading] = useState(false);
  const [error, setError] = useState();
  const [errorMessage, setErrorMessagge] = useState("");

  const columns = useMemo(handleRow => [
    {
      name: "Nomor Registrasi",
      selector: "registration_no",
      sortable: true,
      ignoreRowClick: true
    },
    {
      name: "Keterangan",
      selector: "project_desc",
      sortable: true,
      ignoreRowClick: true
    },
    {
      name: "Sumber Tender",
      selector: "project_source",
      sortable: true,
      ignoreRowClick: true
    },
    {
      name: "Tanggal Mulai Project",
      selector: "project_start_date",
      cell: row => formatDate(row.project_start_date),
      sortable: true,
      ignoreRowClick: true
    },
    {
      name: "Tanggal Akhir Project",
      selector: "project_end_date",
      cell: row => formatDate(row.project_end_date),
      sortable: true,
      ignoreRowClick: true
    },
    {
      name: "Nilai Project",
      selector: "project_value",
      cell: row => formatNumber(row.project_value),
      sortable: true,
      right: true,
      ignoreRowClick: true
    },
    {
      name: "Actions",
      selector: "id",
      ignoreRowClick: true,
      cell: row => (
        <React.Fragment>
          <a
            className="btn btn-xs btn-link"
            data-tag="allowRowEvents"
            // onClick={handleRow}
            target="_blank"
            href={`${window.location.href}/upload/${row.id}`}
          >
            upload File
          </a>
          <a
            className="btn btn-xs btn-link"
            data-tag="allowRowEvents"
            // onClick={handleRow}
            target="_blank"
            href={`${window.location.href}/upload/${row.id}`}
          >
            Detail
          </a>
        </React.Fragment>
      )
    }
    // ,{
    //   name:'STATUS',
    //   selector:'active',
    //   cell: row => row.active === '0' ? <span className="label label-danger">inactive</span> : <span className="label label-success">active</span>,
    //   sortable:true
    // }
  ]);

  const handleRow = event => {
    console.log(event);
  };

  useEffect(() => {
    setError(false);
    setErrorMessagge("");
    setIsDataLoading(true);
    const fetchData = async () => {
      try {
        const result = await axios("/project/daftar_project");
        setData(result.data);
      } catch (error) {
        setError(true);
        setErrorMessagge("terjadi kesalahan pada saat mengambil data!");
      }
      setIsDataLoading(false);
    };
    fetchData();
  }, []);

  return (
    <Container>
      <BreadCrumb breadcrumb={BREADCRUMB_DAFTAR_PROJECT} />
      <Card title="Daftar Tender">
        {error ? (
          <h4 className="text-center">{errorMessage}</h4>
        ) : (
          <DataTableExtensions
            exportHeaders
            columns={columns}
            data={data}
            filterPlaceholder="Filter Tabel Berdasarkan Kolom"
          >
            <DataTable
              fixedHeader
              subHeader={false}
              subHeaderWrap
              noHeader
              progressPending={isDataLoading}
              columns={columns}
              data={data}
              compact
              striped
              responsive
              highlightOnHover
              pointerOnHover
              onRowClicked={row => handleRow(row)}
              pagination
            />
          </DataTableExtensions>
        )}
      </Card>
    </Container>
  );
}

// class DaftarProject extends React.Component {
//   constructor(props) {
//     super(props);
//     this.state = {
//       data: [],
//       isDataLoading: false
//     };
//   }

//   componentDidMount() {
//     axios
//       .get("/project/daftar_project")
//       .then(res => {
//         console.log(res);
//         if (res.status === 200) {
//           // console.log('test')
//           this.setState({
//             data: res.data,
//             isDataLoading: true
//           });
//         }
//       })
//       .then(result => {
//         this.setState({
//           isDataLoading: false
//         });
//       })
//       .catch(err => console.log(err));
//   }

//   handleRow() {
//     alert(1);
//   }

//   render() {
//     const { data, isDataLoading } = this.state;
//     // const tableData = { columns, data };
//     return (
//       <Container>
//         <BreadCrumb breadcrumb={BREADCRUMB_DAFTAR_PROJECT} />
//         <Card title="Daftar Tender">
//           <DataTableExtensions exportHeaders columns={columns} data={data}>
//             <DataTable
//               progressPending={isDataLoading}
//               columns={columns}
//               data={data}
//               striped
//               responsive
//               onRowClicked={cb => console.log(cb)}
//               pagination
//             />
//           </DataTableExtensions>
//         </Card>
//       </Container>
//     );
//   }
// }

export default DaftarProject;
if (document.getElementById("daftar-project")) {
  const element = document.getElementById("daftar-project");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <DaftarProject {...props} />,
    document.getElementById("daftar-project")
  );
}

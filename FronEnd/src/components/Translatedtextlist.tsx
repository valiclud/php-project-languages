import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import {
  DataGrid,
  type GridColDef,
  type GridCellParams,
} from "@mui/x-data-grid";
import IconButton from "@mui/material/IconButton";
import DeleteIcon from "@mui/icons-material/Delete";
import Snackbar from "@mui/material/Snackbar";
import {
  getTranslatedtexts,
  deleteTranslatedtext,
} from "../api/translatedtextapi";
import AddTranslatedtext from "./AddTranslatedtext";
import EditTranslatedtext from "./EditTranslatedtext";

function GetTranslatedtextlist() {
  const [open, setOpen] = useState(false);
  const queryClient = useQueryClient();
  const { data, error, isSuccess } = useQuery({
    queryKey: ["translatedtexts"],
    queryFn: getTranslatedtexts,
  });
  const { mutate } = useMutation({
    mutationFn: deleteTranslatedtext,
    onSuccess: () => {
      setOpen(true);
      queryClient.invalidateQueries({ queryKey: ["translatedtexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });
  const columns: GridColDef[] = [
    { field: "idtranstext", headerName: "ID", width: 80 },
    { field: "transtexttitle", headerName: "Trans Text Title", width: 150 },
    { field: "transtexttext", headerName: "Text", width: 200 },
    { field: "transtextlanguage", headerName: "Language", width: 150 },
    { field: "transtextdate", headerName: "Insert Date", width: 100 },
    { field: "revision", headerName: "Revision", width: 100 },
    { field: "idauthor", headerName: "Translation Author Id", width: 150 },
    { field: "idorigtext", headerName: "Orig Text Id", width: 100 },
    {
      field: "edit",
      headerName: "",
      width: 90,
      sortable: false,
      filterable: false,
      disableColumnMenu: true,
      renderCell: (params: GridCellParams) => (
        <EditTranslatedtext translatedtextdata={params.row} />
      ),
    },
    {
      field: "delete",
      headerName: "",
      width: 90,
      sortable: false,
      filterable: false,
      disableColumnMenu: true,
      renderCell: (params: GridCellParams) => (
        <IconButton
          aria-label="delete"
          size="small"
          onClick={() => {
            if (
              window.confirm(
                `Are you sure you want to delete ${params.row.origtexttitle} ?`,
              )
            ) {
              mutate(params.row.idtranstext);
            }
          }}
        >
          <DeleteIcon fontSize="small" />
        </IconButton>
      ),
    },
  ];
  if (!isSuccess) {
    return <span>Loading...</span>;
  } else if (error) {
    return <span>Error when fetching texts...</span>;
  } else {
    return (
      <>
        <AddTranslatedtext />
        <DataGrid
          rows={data}
          columns={columns}
          getRowId={(row) => row.idtranstext}
          showToolbar
        />
        <Snackbar
          open={open}
          autoHideDuration={2000}
          onClose={() => setOpen(false)}
          message="Translated Text deleted"
        />
      </>
    );
  }
}
export default GetTranslatedtextlist;

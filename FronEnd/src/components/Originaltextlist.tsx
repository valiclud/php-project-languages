import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import {
  DataGrid,
  type GridColDef,
  type GridCellParams,
} from "@mui/x-data-grid";
import { getOriginaltexts, deleteOriginaltext } from "../api/originaltextapi";
import Snackbar from "@mui/material/Snackbar";
import AddOriginaltext from "./AddOriginaltext";

function GetOriginaltextlist() {
  const [open, setOpen] = useState(false);
  const queryClient = useQueryClient();
  const { data, error, isSuccess } = useQuery({
    queryKey: ["originaltexts"],
    queryFn: getOriginaltexts,
  });
  const { mutate } = useMutation({
    mutationFn: deleteOriginaltext,
    onSuccess: () => {
      setOpen(true);
      queryClient.invalidateQueries({ queryKey: ["originaltexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });
  const columns: GridColDef[] = [
    { field: "author_text", headerName: "Author Text", width: 200 },
    { field: "text", headerName: "Text", width: 200 },
    { field: "title", headerName: "Title", width: 200 },
    { field: "text_img", headerName: "Text Image", width: 200 },
    { field: "insert_date", headerName: "Insert Date", width: 150 },
    { field: "hits", headerName: "Hits", width: 150 },
    { field: "place_id", headerName: "Place Id", width: 150 },
    { field: "old_language_id", headerName: "Old Language Id", width: 150 },
    { field: "author_id", headerName: "Translation Author Id", width: 150 },
    {
      field: "delete",
      headerName: "",
      width: 90,
      sortable: false,
      filterable: false,
      disableColumnMenu: true,
      renderCell: (params: GridCellParams) => (
        <button
          onClick={() => {
            if (
              window.confirm(
                `Are you sure you want to delete ${params.row.origtexttitle} ?`,
              )
            ) {
              mutate(params.row.id);
            }
          }}
        >
          Delete
        </button>
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
        <AddOriginaltext />
        <DataGrid rows={data} columns={columns} getRowId={(row) => row.id} />
        <Snackbar
          open={open}
          autoHideDuration={2000}
          onClose={() => setOpen(false)}
          message="Original Text deleted"
        />
      </>
    );
  }
}
export default GetOriginaltextlist;
